<?php // Форма редагування та перелік записів обраного розділу. ?>
<?php  if ( $showform): ?>

    <form class="panel admin-form" method="post" enctype="multipart/form-data">
        <?php csrf(); ?>
        <input type="hidden" name="id" value="<?= $id ?>" />
        <h2><?= $id ? "Edit" : "Add" ?> <?= e(strtolower($sec["title"])) ?></h2>
        <div class="admin-fields">
            <?php
            foreach ($sec["fields"] as $field => $type):
                $value = $editing[$field] ?? ($type === "date" ? date("Y-m-d") : ""); ?>
            <label>
                <?=
                e(preg_replace("/([a-z])([A-Z])/", '$1 $2', str_replace("_ID", "", $field))) ?>
                <?php if (in_array($type, ["movie", "hall", "genre", "version"])):
                    $opts = [
                        "movie" => ["Movie", "Movie_ID", "Title"],
                        "hall" => ["CinemaHall", "CinemaHall_ID", "Name"],
                        "genre" => ["Genre", "Genre_ID", "Name"],
                        "version" => ["Version", "Version_ID", "Format"],
][$type]; ?>
                <select name="<?= $field ?>" required>
                    <?php foreach ( $options[$type] as $opt): ?>
                    <option value="<?= $opt[$opts[1]] ?>" <?= $value == $opt[$opts[1]] ? "selected" : "" ?>><?= e($opt[$opts[2]]) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
                elseif ($type === "textarea"): ?>
                <textarea name="<?= $field ?>" rows="5" required><?= e($value) ?></textarea>
                <?php else: ?>
                <input
                    type="<?= $type ?>"
                    name="<?= $field ?>"
                    value="<?= e($value) ?>"
                    <?= $field === "TrailerLink" ? "" : "required" ?>
                    <?= $type === "number" ? 'min="0" step="any"' : "" ?>
                    <?= $type === "time" ? 'step="1"' : "" ?>
                />
                <?php endif; ?>
            </label>
            <?php
            endforeach; if ( $key === "movies"): ?>
            <label>
                Poster (JPG / PNG / WebP)
                <input type="file" name="poster" accept="image/jpeg,image/png,image/webp" />
            </label>
            <label>
                Landscape image
                <input type="file" name="gallery" accept="image/jpeg,image/png,image/webp" />
            </label>
            <p class="muted">
                Use a 2:3 poster and a landscape image. Leaving an upload empty keeps the current image.
            </p>
            <?php endif; ?>
        </div>
        <button class="button">Save changes ↗</button>
        <a class="text-link" href="<?= url("admin/manage-" . $key) ?>">Cancel</a>
    </form>
    <?php endif; if ($key !== "company"): ?>
    <a class="button small" href="<?= url("admin/manage-" . $key . "?new=1") ?>">Add new +</a>
    <?php endif; ?>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <?php
                    $visible = array_slice(array_keys($sec["fields"]), 0, 4); foreach ($visible as $f): ?>
                    <th><?= e(str_replace("_", " ", $f)) ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r[$sec["pk"]] ?></td>
                    <?php foreach ( $visible as $f): ?>
                    <td><?= e(mb_strimwidth((string) $r[$f], 0, 100, "…", "UTF-8")) ?></td>
                    <?php endforeach; ?>
                    <td class="row-actions">
                        <a href="<?= url("admin/manage-" . $key . "?edit=" . $r[$sec["pk"]]) ?>">Edit</a>
                        <?php if ( $key !== "company"): ?>

                        <form method="post" data-confirm="Delete this item? Booked items cannot be deleted.">
                            <?php csrf(); ?>
                            <input type="hidden" name="id" value="<?= $r[$sec["pk"]] ?>" />
                            <button name="delete" class="text-button danger">Delete</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
