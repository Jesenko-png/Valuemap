import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const sourcePath = path.join(root, 'storage', 'app', 'ne_110m_admin_0_countries.geojson');
const outputPath = path.join(root, 'resources', 'views', 'partials', 'europe-map.blade.php');
const geojson = JSON.parse(fs.readFileSync(sourcePath, 'utf8'));

const bounds = { minX: -25, maxX: 45, minY: 34, maxY: 72 };
const members = new Set(['ESP', 'PRT', 'SWE', 'HUN', 'BIH', 'IRL']);

const project = ([lon, lat]) => [
    40 + ((lon - bounds.minX) / (bounds.maxX - bounds.minX)) * 820,
    30 + ((bounds.maxY - lat) / (bounds.maxY - bounds.minY)) * 560,
];

const clipEdge = (points, inside, intersect) => {
    const result = [];
    for (let index = 0; index < points.length; index += 1) {
        const current = points[index];
        const previous = points[(index + points.length - 1) % points.length];
        const currentInside = inside(current);
        const previousInside = inside(previous);

        if (currentInside) {
            if (!previousInside) result.push(intersect(previous, current));
            result.push(current);
        } else if (previousInside) {
            result.push(intersect(previous, current));
        }
    }
    return result;
};

const clipPolygon = (ring) => {
    let points = ring.slice(0, -1);
    const vertical = (value) => (a, b) => {
        const ratio = (value - a[0]) / (b[0] - a[0]);
        return [value, a[1] + (b[1] - a[1]) * ratio];
    };
    const horizontal = (value) => (a, b) => {
        const ratio = (value - a[1]) / (b[1] - a[1]);
        return [a[0] + (b[0] - a[0]) * ratio, value];
    };

    points = clipEdge(points, ([x]) => x >= bounds.minX, vertical(bounds.minX));
    points = clipEdge(points, ([x]) => x <= bounds.maxX, vertical(bounds.maxX));
    points = clipEdge(points, ([, y]) => y >= bounds.minY, horizontal(bounds.minY));
    points = clipEdge(points, ([, y]) => y <= bounds.maxY, horizontal(bounds.maxY));
    return points;
};

const escape = (value) => String(value).replaceAll('&', '&amp;').replaceAll('"', '&quot;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');
const format = (value) => Number(value.toFixed(1));

const features = geojson.features
    .filter((feature) => feature.properties.CONTINENT === 'Europe' || ['TUR', 'CYP'].includes(feature.properties.ADM0_A3))
    .sort((a, b) => String(a.properties.NAME_EN).localeCompare(String(b.properties.NAME_EN)));

const groups = features.map((feature) => {
    const polygons = feature.geometry.type === 'Polygon' ? [feature.geometry.coordinates] : feature.geometry.coordinates;
    const paths = polygons.map((polygon) => clipPolygon(polygon[0]))
        .filter((ring) => ring.length >= 3)
        .map((ring) => `${ring.map((point, index) => {
            const [x, y] = project(point);
            return `${index === 0 ? 'M' : 'L'}${format(x)} ${format(y)}`;
        }).join(' ')} Z`)
        .join(' ');

    if (!paths) return '';
    const code = feature.properties.ADM0_A3;
    const name = feature.properties.NAME_EN || feature.properties.NAME;
    const classes = members.has(code) ? 'europe-country is-member-country' : 'europe-country';
    return `    <path class="${classes}" data-country-code="${escape(code)}" d="${paths}"><title>${escape(name)}</title></path>`;
}).filter(Boolean);

const output = `{{-- Generated from Natural Earth public-domain Admin 0 country boundaries. --}}\n<g class="europe-countries">\n${groups.join('\n')}\n</g>\n`;
fs.writeFileSync(outputPath, output);
console.log(`Generated ${groups.length} European country paths in ${path.relative(root, outputPath)}.`);
