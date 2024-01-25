import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js'
import './main.css'

registerBlockType('ept-user-flow/header-tools', {
  icon: {
    src: icons.user_bubble
  },
  edit({ attributes, setAttributes }) {
    const {showAuth} = attributes
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('General', 'e-potis') }>
            <SelectControl 
                label = {__('Show Login/Register link', 'udemy_plus')}
                value = {showAuth}
                options={[
                    { label: __('No', 'e-potis'), value:false},
                    { label: __('Yes', 'e-potis'), value:true}
                ]}
                onChange={newVal => setAttributes({ showAuth: (newVal === "true")})}
            />
            <CheckboxControl
                label={__('Show Login/Register Link', 'e-potis')} 
                help={
                    showAuth ?
                    __('Showing Link', 'e-potis') :
                    __('Hiding Link', 'e-potis')
                }
                checked={showAuth}
                onChange={showAuth => setAttributes({showAuth})}
            />
          </PanelBody>
        </InspectorControls>
        <div { ...blockProps }>
          {
          showAuth && 
            <a className="signin-link open-modal" href="#">
              <div className="signin-icon">
                <i className="bi bi-person-circle"></i>
              </div>
              <div className="signin-text">
                <small>Hello,<div className = 'signin-text-link'> Sign in </div></small>
                My Account
              </div>
          </a> 
          }
        </div>
      </>
    );
  }
});