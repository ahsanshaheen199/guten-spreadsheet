<?php
class SheetBlock {
    public $service;
    public function __construct() {
        add_action( 'init', [$this,'guten_spreadsheet_register_block'] );
    }

    public function getService($service) {
        $this->service = $service;
    }

    public function guten_spreadsheet_register_block() {

        $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
    
        wp_register_script(
            'guten-spreadsheet',
            plugins_url( 'build/index.js', __FILE__ ),
            $asset_file['dependencies'],
            $asset_file['version']
        );
    
        register_block_type( 'guten-spreadsheet/guten-spreadsheet-card', array(
            'editor_script' => 'guten-spreadsheet',
            'render_callback' => [$this,'render_block_guten_spreadsheet_card'],
            'attributes'      => [
                'sheetId'     => [
                    'type'    => 'string',
                    'default' => '',
                ],
                'sheetRange'     => [
                    'type'    => 'string',
                    'default' => '',
                ]
            ],
        ) );
    
    }

    public function render_block_guten_spreadsheet_card($attributes) {
        $html = '<table style="width:100%;border-collapse: collapse;border: 1px solid black">';
        $values = $this->getsheetValues($attributes['sheetId'],$attributes['sheetRange']);
        if( !empty( $values ) ) {
            foreach( $values as $value ) {
                $html .= '<tr style="border: 1px solid black">';
                foreach( $value as $singlevalue ) {
                    $html .= '<td style="border: 1px solid black;text-align:center;padding: 5px;">'.$singlevalue.'</td>';
                }
                $html .= '</tr>'; 
            }
        }

        $html .= '</table>';
    
        return $html;
    }

    public function getsheetValues($sheetId,$sheetRange) {
        $response = $this->service->spreadsheets_values->get($sheetId,$sheetRange);
        $values = $response->getValues();

        return $values;
    }
    
}


