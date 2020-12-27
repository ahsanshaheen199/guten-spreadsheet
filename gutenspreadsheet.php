<?php
/*
Plugin Name: Guten Spreadsheet
Plugin URI: https://github.com/ahsanshaheen199
Description: Guten Spreadsheet
Author: Ahsan Habib Shaheen
Version: 1.0
*/

require __DIR__ . '/vendor/autoload.php';

add_action( 'admin_menu', 'guten_spreadsheet_admin_page' );
function guten_spreadsheet_admin_page() {
    add_menu_page(
        'Guten Sheet',
        'Guten Sheet',
        'manage_options',
        'guten-spreadsheet',
        'guten_spreadsheet_page_html',
        'dashicons-admin-appearance',
        20
    );
}


function guten_spreadsheet_page_html() { ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
            settings_fields( 'guten-spreadsheet' );
            do_settings_sections( 'guten-spreadsheet' );    
            submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
<?php }


add_action('admin_init','guten_spreadsheet_register_settings');

function guten_spreadsheet_register_settings() {
    register_setting('guten-spreadsheet','gutenspreadsheet_options');

    add_settings_section(
        'gutenspreadsheet_api_section',
        'Api Key',
        'gutenspreadsheet_api_section_cb',
        'guten-spreadsheet'
    );

    add_settings_field( 'gutenspreadsheet_api', 'Api Key', 'gutenspreadsheet_api_field', 'guten-spreadsheet', 'gutenspreadsheet_api_section');
}


function gutenspreadsheet_api_section_cb() {}


function gutenspreadsheet_api_field() { 
        $api_key = get_option('gutenspreadsheet_options');
    ?>
    <input type="text" name="gutenspreadsheet_options" class="regular-text" value="<?php echo $api_key; ?>">
<?php }


    $client = new Google_Client();
    $api_key = sanitize_text_field(get_option('gutenspreadsheet_options'));
    $service="";
    $client->setDeveloperKey( $api_key );
    $service = new Google_Service_Sheets( $client );


    require __DIR__ . '/block.php';

    $sheetBlock = new SheetBlock();
    $sheetBlock->getService($service);