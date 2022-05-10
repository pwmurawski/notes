<article class="show">
    <?php $note = $params['noteData'] ?? null; ?>
    <?php if($note): ?>
        <ul>
            <li>Id: <?php echo $note['id'] ?></li>
            <li>Tytuł: <?php echo $note['title'] ?></li>
            <li><?php echo $note['description'] ?></li>
            <li>Zapisano: <?php echo $note['created'] ?></li>
        </ul>
        <form action="/?action=delete" method="POST">
            <input type="hidden" name="id" value="<?php echo $note['id'] ?>" />
            <input type="submit" value="Usun" />
        </form>
    <?php else: ?>
        <h2>Brak notatki</h2>
    <?php endif; ?>
    <a href="/">
        <button>Powrót do listy notatek</button>
    </a>
</article>