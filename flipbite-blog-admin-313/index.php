<?php
require_once __DIR__ . '/auth.php';
require_login();

$postsDir = __DIR__ . '/../posts';
$posts = [];
if (is_dir($postsDir)) {
    foreach (scandir($postsDir) as $file) {
        if (substr($file, -3) !== '.md') continue;
        $slug = substr($file, 0, -3);
        $raw = file_get_contents($postsDir . '/' . $file);
        $data = ['slug' => $slug, 'title' => $slug, 'date' => '', 'category' => 'General', 'excerpt' => '', 'author' => '', 'author_role' => '', 'featured' => false, 'body' => $raw];
        if (preg_match('/^---\r?\n(.*?)\r?\n---\r?\n?(.*)$/s', $raw, $m)) {
            $data['body'] = trim($m[2]);
            foreach (preg_split('/\r?\n/', $m[1]) as $line) {
                if (preg_match('/^([a-zA-Z0-9_]+):\s*(.*)$/', $line, $lm)) {
                    $value = trim($lm[2]);
                    if ((str_starts_with($value, '"') && str_ends_with($value, '"')) || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                        $value = substr($value, 1, -1);
                    } elseif ($value === 'true') { $value = true; }
                    elseif ($value === 'false') { $value = false; }
                    $data[$lm[1]] = $value;
                }
            }
        }
        $posts[] = $data;
    }
}
usort($posts, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));

$editSlug = $_GET['edit'] ?? null;
$editPost = null;
if ($editSlug) {
    foreach ($posts as $p) {
        if ($p['slug'] === $editSlug) { $editPost = $p; break; }
    }
}
$showForm = isset($_GET['new']) || $editPost;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | FlipBite</title>
  <meta name="robots" content="noindex, nofollow">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style type="text/tailwindcss">
    @theme { --font-sans: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#fafafa] font-sans antialiased text-[#0f172a] min-h-screen">

  <nav class="bg-white border-b border-[#e2e8f0] px-[24px] py-[16px] flex items-center justify-between">
    <div class="flex items-center gap-[10px]">
      <div class="w-[28px] h-[28px]">
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
          <path d="M20 4L36 20L20 36L4 20L20 4Z" fill="url(#g)" fill-opacity="0.15" stroke="url(#g)" stroke-width="3" stroke-linejoin="round"/>
          <path d="M12 20L20 12L28 20" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M16 24L20 20L24 24" stroke="#3B82F6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="20" cy="20" r="2" fill="#10B981"/>
          <defs><linearGradient id="g" x1="4" y1="4" x2="36" y2="36"><stop stop-color="#10B981"/><stop offset="1" stop-color="#3B82F6"/></linearGradient></defs>
        </svg>
      </div>
      <span class="font-bold text-[16px]">FlipBite Admin</span>
    </div>
    <a href="logout.php" class="text-[14px] font-medium text-[#475569] hover:text-[#0f172a]">Log Out</a>
  </nav>

  <main class="max-w-4xl mx-auto px-4 py-[48px]">

    <?php if ($showForm): ?>
      <!-- ADD / EDIT FORM -->
      <div class="bg-white border border-[#e2e8f0] rounded-[20px] p-[32px] shadow-sm mb-[40px]">
        <h2 class="text-[22px] font-bold mb-[24px]"><?= $editPost ? 'Edit Post' : 'New Post' ?></h2>
        <form method="POST" action="save.php" class="flex flex-col gap-[16px]">
          <input type="hidden" name="original_slug" value="<?= htmlspecialchars($editPost['slug'] ?? '') ?>">

          <div>
            <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Title</label>
            <input type="text" name="title" required value="<?= htmlspecialchars($editPost['title'] ?? '') ?>"
              class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
          </div>

          <div class="grid grid-cols-2 gap-[16px]">
            <div>
              <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Publish Date</label>
              <input type="date" name="date" required value="<?= htmlspecialchars($editPost['date'] ?? date('Y-m-d')) ?>"
                class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
            </div>
            <div>
              <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Category</label>
              <select name="category" class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
                <?php foreach (['Research', 'Technical', 'Authority', 'Influencer', 'General'] as $cat): ?>
                  <option value="<?= $cat ?>" <?= (($editPost['category'] ?? '') === $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Short Excerpt (shown on the blog list)</label>
            <textarea name="excerpt" rows="2" required
              class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]"><?= htmlspecialchars($editPost['excerpt'] ?? '') ?></textarea>
          </div>

          <div class="grid grid-cols-2 gap-[16px]">
            <div>
              <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Author Name</label>
              <input type="text" name="author" value="<?= htmlspecialchars($editPost['author'] ?? 'FlipBite Team') ?>"
                class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
            </div>
            <div>
              <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Author Role</label>
              <input type="text" name="author_role" value="<?= htmlspecialchars($editPost['author_role'] ?? '') ?>"
                class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
            </div>
          </div>

          <label class="flex items-center gap-[8px] text-[14px] font-medium text-[#475569]">
            <input type="checkbox" name="featured" value="1" <?= !empty($editPost['featured']) ? 'checked' : '' ?>>
            Feature this post at the top of the blog page
          </label>

          <div>
            <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Post Content (Markdown supported: ## Heading, **bold**, - list item)</label>
            <textarea name="body" rows="14" required
              class="w-full px-[14px] py-[10px] rounded-[10px] border border-[#e2e8f0] text-[15px] font-mono focus:outline-none focus:border-[#10B981]"><?= htmlspecialchars($editPost['body'] ?? '') ?></textarea>
          </div>

          <div class="flex items-center gap-[12px] mt-[8px]">
            <button type="submit" class="bg-[#111827] text-white px-[24px] py-[12px] rounded-[12px] font-medium text-[15px] hover:bg-[#1E293B] transition-colors">
              <?= $editPost ? 'Save Changes' : 'Publish Post' ?>
            </button>
            <a href="index.php" class="text-[14px] font-medium text-[#475569] hover:text-[#0f172a]">Cancel</a>
          </div>
        </form>
      </div>
    <?php else: ?>
      <div class="flex items-center justify-between mb-[24px]">
        <h1 class="text-[26px] font-bold">Blog Posts</h1>
        <a href="?new=1" class="bg-[#111827] text-white px-[20px] py-[10px] rounded-[12px] font-medium text-[14px] hover:bg-[#1E293B] transition-colors">+ New Post</a>
      </div>

      <?php if (empty($posts)): ?>
        <p class="text-[#475569]">No posts yet — click "+ New Post" to write your first one.</p>
      <?php else: ?>
        <div class="flex flex-col gap-[12px]">
          <?php foreach ($posts as $p): ?>
            <div class="bg-white border border-[#e2e8f0] rounded-[16px] p-[20px] flex items-center justify-between gap-[16px]">
              <div>
                <div class="flex items-center gap-[8px] mb-[4px]">
                  <span class="text-[11px] font-bold uppercase tracking-wide text-[#475569] bg-[#F1F5F9] px-[8px] py-[2px] rounded-full"><?= htmlspecialchars($p['category']) ?></span>
                  <?php if (!empty($p['featured'])): ?><span class="text-[11px] font-bold uppercase tracking-wide text-[#10B981] bg-[#F0FDF4] px-[8px] py-[2px] rounded-full">Featured</span><?php endif; ?>
                  <span class="text-[12px] text-[#94A3B8]"><?= htmlspecialchars($p['date']) ?></span>
                </div>
                <div class="font-bold text-[16px]"><?= htmlspecialchars($p['title']) ?></div>
              </div>
              <div class="flex items-center gap-[16px] shrink-0">
                <a href="../post.html?slug=<?= urlencode($p['slug']) ?>" target="_blank" class="text-[13px] font-medium text-[#475569] hover:text-[#0f172a]">View</a>
                <a href="?edit=<?= urlencode($p['slug']) ?>" class="text-[13px] font-medium text-[#3B82F6] hover:underline">Edit</a>
                <form method="POST" action="delete.php" onsubmit="return confirm('Delete this post? This cannot be undone.');">
                  <input type="hidden" name="slug" value="<?= htmlspecialchars($p['slug']) ?>">
                  <button type="submit" class="text-[13px] font-medium text-[#DC2626] hover:underline">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </main>
</body>
</html>
