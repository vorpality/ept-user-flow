import { registerBlockType } from '@wordpress/blocks'
import { 
  useBlockProps, 
  InspectorControls
} from '@wordpress/block-editor'
import { __ } from '@wordpress/i18n'
import { 
  PanelBody, 
  TextControl,
  RangeControl,
  SelectControl,
  ColorPalette,
  CheckboxControl
} from '@wordpress/components'
import './main.css'
import block from './block.json'

registerBlockType(block.name, {
  edit() {}
});
