import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js'
import './main.css'

registerBlockType('ept-user-flow/auth-modal', {
  icon: {
    src: icons.login
  }, 
  edit({ attributes, setAttributes }) {
    const { showRegister } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('General', 'e-potis') }>
            <ToggleControl 
            label = {__('Show Register', 'e-potis')}
            help = {
                showRegister ? 
                __('Showing registration form', 'e-potis') : 
                __('Hiding registration form', 'e-potis')
            }
            checked ={showRegister}
            onChange = { showRegister => setAttributes({showRegister})}
            />
          </PanelBody>
        </InspectorControls>
        <div { ...blockProps }>
          {__('This block is not previewable from the editor. View your site for a live demo.', 'e-potis')}
        </div>
      </>
    );
  }
});