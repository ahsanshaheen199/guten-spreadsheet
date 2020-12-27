import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { TextControl, PanelBody } from '@wordpress/components';
import ServerSideRender from "@wordpress/server-side-render";
import { Fragment } from "@wordpress/element";
import {
	InspectorControls
} from '@wordpress/block-editor';

registerBlockType( 'guten-spreadsheet/guten-spreadsheet-card', {
	title: __( 'Google Sheet', 'gutenberg-examples' ),
	icon: 'universal-access-alt',
    category: 'layout',
    attributes: {
        'sheetId'     : {
            'type'    : 'string',
            'default' : '',
        },
        'sheetRange'     : {
            'type'    : 'string',
            'default' : '',
        }
    },
	edit(props) {
        const { sheetId,sheetRange } = props.attributes;
		return (
            <Fragment>
                {
                    <InspectorControls>
                        <PanelBody title="Google Sheet" initialOpen={ true }>
                            <TextControl
                                label="Sheet ID"
                                value={ sheetId }
                                onChange={(sheetId) => props.setAttributes({sheetId})}
                            />
                            <TextControl
                                label="Sheet Range"
                                value={ sheetRange }
                                onChange={(sheetRange) => props.setAttributes({sheetRange})}
                            />
                        </PanelBody>
                    </InspectorControls>
                }
                <ServerSideRender block="guten-spreadsheet/guten-spreadsheet-card" attributes={props.attributes} />
            </Fragment>
		);
	},
	save() {
		return null;
	},
} );