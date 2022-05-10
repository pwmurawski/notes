<section>
    <h3>Edycja notatki</h3>
        <div>
            <?php if($params): ?>
                <?php $note = $params['noteData'] ?>
                <form class="note-form" action="/?action=edit" method="POST">
                    <input value="<?php echo $note['id'] ?>" type="hidden" name="id"/>
                    <ul>
                        <li>
                            <label>Tytuł <span class="required">*</span></label>
                            <input value="<?php echo $note['title'] ?>" type="text" name="title" class="field-long" />
                        </li>
                        <li>
                            <label>Treść</label>
                            <textarea name="description" id="field5"
                            class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
                        </li>
                        <li>
                            <input type="submit" value="Submit" />
                        </li>
                    </ul>
                </form>
            <?php else: ?>
                <h2>Brak notatki</h2>
            <?php endif; ?>
            <a href="/">
                <button>Powrót do listy notatek</button>
            </a>
        </div>
</section>