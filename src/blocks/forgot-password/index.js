import { registerBlockType } from '@wordpress/blocks';
import { 
  useBlockProps
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js';
import './main.css';

registerBlockType('ept-user-flow/forgot-password', {
  icon: {
    src: icons.forgot
  },
  edit({ attributes}) {
    const {} = attributes;
    const blockProps = useBlockProps();

    return (
      <div {...blockProps}>
      <form>
          <label>Enter the email associated with your account.</label>
            <input type="text" id="f-email" placeholder="someone@example.com"></input>
            <div className='btn-wrapper'>
              <button type="submit" style={{
                'background-color': '#000',
                color : '#fff'
              }}
              >Submit</button>
            </div>
        </form>
        </div>
    )
  }
});