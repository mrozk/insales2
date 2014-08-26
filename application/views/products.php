<table border="1">
    <thead>
    <th>Название</th>
    <th>Автор</th>
    </thead>
    <tbody>
    <?php
        foreach ($books as $book) { ?>
        <tr>
            <td><?php echo $book['title']; ?></td>
        </tr>
    <?php }; ?>
    </tbody>
</table>