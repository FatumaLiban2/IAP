<?php
// A simple class for static HTML layouts that complements the new classes.
class layouts {
    /**
     * Creates a simple header for the page.
     * @return void
     */
    public function header($conf = null) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $conf ? $conf['site_lang'] : 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $conf ? $conf['site_name'] : 'Alliance Girls High School'; ?></title>
            
        </head>
        <body>
        <h1><?php echo $conf ? $conf['site_name'] : 'Alliance Girls High School'; ?></h1>
        <?php
    }

    /**
     * Creates a simple footer for the page.
     * @return void
     */
    public function footer($conf = null) {
        ?>
        <hr>
        <p>Created by School-management - All Rights Reserved</p>
        <?php if ($conf): ?>
            <p>Contact Admin: <?php echo $conf['admin_email']; ?></p>
        <?php endif; ?>
        </body>
        </html>
        <?php
    }
}
?>
