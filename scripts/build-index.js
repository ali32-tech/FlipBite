// Reads every markdown post in /posts, parses its YAML-ish frontmatter,
// and writes posts/index.json — the file blog.html fetches at runtime.
// Runs automatically as the Netlify build command. No dependencies.

const fs = require('fs');
const path = require('path');

const POSTS_DIR = path.join(__dirname, '..', 'posts');
const OUTPUT_FILE = path.join(POSTS_DIR, 'index.json');

function parseFrontmatter(raw) {
  const match = raw.match(/^---\r?\n([\s\S]*?)\r?\n---/);
  if (!match) return { data: {}, body: raw };

  const data = {};
  for (const line of match[1].split(/\r?\n/)) {
    const lineMatch = line.match(/^([a-zA-Z0-9_]+):\s*(.*)$/);
    if (!lineMatch) continue;
    let value = lineMatch[2].trim();
    if (
      (value.startsWith('"') && value.endsWith('"')) ||
      (value.startsWith("'") && value.endsWith("'"))
    ) {
      value = value.slice(1, -1);
    } else if (value === 'true') {
      value = true;
    } else if (value === 'false') {
      value = false;
    }
    data[lineMatch[1]] = value;
  }

  const body = raw.slice(match[0].length).trim();
  return { data, body };
}

function build() {
  if (!fs.existsSync(POSTS_DIR)) {
    console.log('No posts directory found, skipping.');
    return;
  }

  const files = fs.readdirSync(POSTS_DIR).filter((f) => f.endsWith('.md'));
  const posts = files.map((file) => {
    const slug = file.replace(/\.md$/, '');
    const raw = fs.readFileSync(path.join(POSTS_DIR, file), 'utf8');
    const { data } = parseFrontmatter(raw);
    return {
      slug,
      title: data.title || slug,
      date: data.date || '',
      category: data.category || 'General',
      excerpt: data.excerpt || '',
      author: data.author || 'FlipBite Team',
      author_role: data.author_role || '',
      image: data.image || '',
      featured: data.featured === true,
    };
  });

  posts.sort((a, b) => new Date(b.date) - new Date(a.date));

  fs.writeFileSync(OUTPUT_FILE, JSON.stringify(posts, null, 2));
  console.log(`Wrote ${posts.length} posts to posts/index.json`);
}

build();
