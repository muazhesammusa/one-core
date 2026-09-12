import fs from 'node:fs';

const pkg = JSON.parse(fs.readFileSync(new URL('../package.json', import.meta.url), 'utf8'));
const expected = 'wp i18n make-pot . languages/one-core.pot --domain=ONE_CORE_SLUG --exclude=node_modules,release,vendor';
if (pkg.scripts?.['i18n:pot'] !== expected) {
  throw new Error('One Core i18n:pot script must preserve the current canonical ONE_CORE_SLUG domain.');
}
if (Object.prototype.hasOwnProperty.call(pkg.scripts ?? {}, 'prebuild')) {
  throw new Error('One Core build must not auto-generate the POT; run npm run i18n:pot manually.');
}
console.log('One Core i18n POT script contract: PASS');
