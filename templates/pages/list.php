<section class="list"> 
    <section class="message">
        <?php
            if($params['before']) {
                switch($params['before']) {
                    case 'created' :
                        echo 'Notatka została utworzona !!!';
                        break;
                    case 'edited' :
                        echo 'Notatka została edytowana !!!';
                        break;
                    case 'deleted' :
                        echo 'Notatka została usunieta !!!';
                        break;
                }
            }
            if($params['error']) {
                switch($params['error']) {
                    case 'missingNoteId' :
                        echo 'Nie poprawny indyfikator';
                        break;
                    case 'noteNotFound' :
                        echo 'Notatka nie istnieje';
                        break;
                }
            }
        ?>
    </section>

    <section>
        <?php $page = $params['page'] ?>
        <?php $sort = $params['sort'] ?>
        <form class="settings-form" action="/" method="GET">
            <div> 
                <label>Wyszukaj: 
                    <input type="text" name="phrase" value="<?php echo $params['phrase']  ?>" />
                </label>
            </div>
            <div>
                <div>Sortuj po: </div>
                <label>Tytule:
                    <input 
                        type="radio" 
                        name="sortBy" 
                        value="title" 
                        <?php echo $sort['by'] === 'title' ? 'checked' : null ?> 
                    />
                </label>
                <label>Dacie: 
                    <input 
                        type="radio"
                        name="sortBy"
                        value="created"
                        <?php echo $sort['by'] === 'created' ? 'checked' : null ?>
                    />
                </label>
            </div>
            <div>
                <div>Kierunek sortowania: </div>
                <label>Rosnaco: 
                    <input
                        type="radio"
                        name="sortOrder"
                        value="asc"
                        <?php echo $sort['order'] === 'asc' ? 'checked' : null ?>
                    />
                </label>
                <label>Malejaco: 
                    <input
                        type="radio"
                        name="sortOrder"
                        value="desc"
                        <?php echo $sort['order'] === 'desc' ? 'checked' : null ?>
                    />
                </label>
            </div>
            <div>
                <div>Rozmiar paczki</div>
                <label>1 
                    <input
                        name="pagesize"
                        value="1"
                        type="radio"
                        <?php echo $page['size'] === 1 ? 'checked' : null ?>
                    />
                </label>
                <label>5 
                    <input
                        name="pagesize"
                        value="5"
                        type="radio"
                        <?php echo $page['size'] === 5 ? 'checked' : null ?>
                    />
                </label>
                <label>10 
                    <input
                        name="pagesize"
                        value="10"
                        type="radio"
                        <?php echo $page['size'] === 10 ? 'checked' : null ?>
                    />
                </label>
                <label>25 
                    <input
                        name="pagesize"
                        value="25"
                        type="radio"
                        <?php echo $page['size'] === 25 ? 'checked' : null ?>
                    />
                </label>
            </div>
            <input type="submit" value="Wyslij" />
        </form>
    </section>

    <article class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tytuł</th>
                    <th>Data</th>
                    <th>Opcje</th>
                </tr>
            </thead>
        </table>
    </article>
    
    <article class="tbl-content">
        <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <?php foreach($params['notes'] ?? [] as $note): ?>
                    <tr>
                        <td><?php echo $note['id'] ?></td>
                        <td><?php echo $note['title'] ?></td>
                        <td><?php echo $note['created'] ?></td>
                        <td>
                            <a href="/?action=show&id=<?php echo $note['id'] ?>">
                                <button>Pokaż</button>
                            </a>
                            <a href="/?action=delete&id=<?php echo $note['id'] ?>">
                                <button>Usun</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>
    <?php $paginationUrl =
        "&phrase={$params['phrase']}&pagesize={$page['size']}&sortBy={$sort['by']}&sortOrder={$sort['order']}" ?>
    <ul class="pagination">
        <?php if($page['currentPage'] !== 1): ?>
            <li>
                <a href="/?page=<?php echo $page['currentPage'] - 1 . $paginationUrl ?>">
                    <button> << </button>
                </a>
            </li>
        <?php endif; ?>
        <?php for($i = 1; $i <= $page['pages']; $i++): ?>
            <li>
                <a href="/?page=<?php echo $i . $paginationUrl ?>">
                    <button>
                        <?php echo $i ?>
                    </button>
                </a>
            </li>
        <?php endfor; ?>
        <?php if($page['currentPage'] !== $page['pages']): ?>
            <li>
                <a href="/?page=<?php echo $page['currentPage'] + 1 . $paginationUrl ?>">
                    <button> >> </button>
                </a>
            </li>
        <?php endif; ?>
    </ul>
 </section>