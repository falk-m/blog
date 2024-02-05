<?php $this->layout('layout/default', ['title' => 'BLOG']) ?>




<div class="c-main">
    <div class="c-main__left">
        <h1 class="c_h1">Blog | falk-m.de</h1>
        <p>
            This blog is not for you, not only.
            Like other developers, I read articles, test new features, analyze code from others and so on.
            Also, I have some interesting code snippets used in projects, if I need them, I always search in old projects.
            This blog is my central place now, to collect interesting code snippets, features, etc.
        </p>

        <hr />

        <?php foreach ($posts as $post) { ?>
            <div class="c-post">
                <img class="c-post__image" src="<?php echo $baseUrl . '/identicon/' . md5($post["header"]["title"] ?? "") . '.svg' ?>" />
                <div class="c-post__content">
                    <h2 class="c-post__headline"><?php echo $post["header"]["title"] ?? "" ?></h2>
                    <span class="c-post__autor">from falk-m.de</span>
                    <span class="c-post__date"> &#183; <?php echo $post["header"]["date"] ?></span>
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
            <?php if ($page > 1) { ?><a class="c-pagination__link" href="?page=<?php echo $page - 1 ?>">previors posts</a><?php } ?>
            <?php if (count($posts) >= $limit) { ?><a class="c-pagination__link" href="?page=<?php echo $page + 1 ?>">older posts</a><?php } ?>
        </div>
    </div>
    <div class="c-main__right">

    </div>
</div>