import { registerBlockType } from '@wordpress/blocks'
import { 
  useBlockProps, PanelColorSettings, InspectorControls 
} from '@wordpress/block-editor'
import { __ } from "@wordpress/i18n"
import icons from '../../icons'
import './main.css'

registerBlockType('ept-user-flow/account-edit-form', {
  edit({ attributes, setAttributes }) {
    const { bgColor, textColor } = attributes
    const blockProps = useBlockProps({
      style: {
        'background-color': bgColor,
        color: textColor
      } 
    })

    return (
      <>
        <InspectorControls>
          <PanelColorSettings 
            title={__('Colors', 'ept-user-flow')}
            colorSettings={[
              { 
                label: __('Background Color', 'ept-user-flow'), 
                value: bgColor,
                onChange: newVal => setAttributes({ bgColor: newVal })
              },
              {
                label: __('Text Color', 'ept-user-flow'),
                value: textColor,
                onChange: newVal => setAttributes({ textColor: newVal })
              }
            ]}
          />
        </InspectorControls>
        <div {...blockProps}>
          <h1>Search: Your search term here</h1>
          <form>
            <input type="text" placeholder="Search" />
            <div className="btn-wrapper">
              <button type="submit" style={{
                'background-color': bgColor,
                color: textColor
              }}>Search</button>
            </div>
          </form>
        </div>
      </>
    )
  }
})