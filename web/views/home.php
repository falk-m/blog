<?php $this->layout('layout/default', ['title' => 'BLOG']) ?>




<div class="c-main">
    <div class="c-main__left">
        <h1 class="c_h1">Blog | falk-m.de</h1>
        <p class="l-mb-2">
            This blog is not for you, not only.
            Like other developers, I read articles, test new features, analyze code from others and so on.
            Also, I have some interesting code snippets used in projects, if I need them, I always search in old projects.
            This blog is my central place now, to collect interesting code snippets, features, etc.
        </p>

        <div class="l-mb-2">

            <form method="GET" class="c-search">
                <input type="text" name="search" class="c-search__input">
                <button type="submit" class="c-search__button">&#128269;</button>
            </form>

            <?php if (!empty($_GET['tag']) || !empty($_GET['search'])) { ?>
                <div class="l-mb-2">
                    <?php if (!empty($_GET['tag'])) { ?>
                        <a class='c-tag' href='<?php echo $baseUrl ?>'><?php echo strip_tags($_GET['tag']); ?> &#10005;</a>
                    <?php } ?>

                    <?php if (!empty($_GET['search'])) { ?>
                        <a class='c-tag' href='<?php echo $baseUrl ?>'><?php echo strip_tags($_GET['search']); ?> &#10005;</a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <?php foreach ($posts as $post) { ?>
            <div class="c-post">
                <img class="c-post__image" src="<?php echo $baseUrl . '/identicon/' . md5($post["header"]["title"] ?? "") . '.svg' ?>" />
                <div class="c-post__content">
                    <h2 class="c-post__headline"><?php echo $post["header"]["title"] ?? "" ?></h2>
                    <span class="c-post__autor">from falk-m.de</span>
                    <span class="c-post__date"> &#183; <?php echo $post["header"]["date"] ?></span>
                    <?php echo  $this->format_tags($post['header']['taxonomy']['tag'] ?? []) ?>
                    <div class="c-post__teaser">
                        <?php echo $post["teaser"] ?>
                    </div>
                    <div class="l-center">
                        <a class="c-post__link" href="<?php echo $post['url'] ?>">read more</a>
                    </div>

                </div>
            </div>

            <hr />

        <?php } ?>

        <div class="c-pagination">
            <?php if ($page > 1) { ?><a class="c-pagination__link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1]))  ?>">previors posts</a><?php } ?>
            <?php if (count($posts) >= $limit) { ?><a class="c-pagination__link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1]))  ?>">older posts</a><?php } ?>
        </div>
    </div>
    <div class="c-main__right">

    </div>
</div>