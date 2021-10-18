<title><?php echo $page['title']; ?></title>
<?php if ($page['title']) { ?>
    <meta name="description" content="<?php echo htmlentities($page['title']); ?>" />
<?php } ?>
<?php if ($page['meta_keywords']) { ?>
    <meta name="keywords" content="<?php echo htmlentities($page['meta_keywords']); ?>" />
<?php } ?>