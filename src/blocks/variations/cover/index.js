import { __ } from '@wordpress/i18n'
import { InspectorControls } from '@wordpress/block-editor'
import { registerBlockVariation } from '@wordpress/blocks'
import {
  Icon,
  PanelBody,
  ColorPicker,
  PanelRow,
  __experimentalText as Text,
  __experimentalToolsPanelItem as ToolsPanelItem
} from '@wordpress/components'
import { addFilter } from '@wordpress/hooks'
import { createHigherOrderComponent } from '@wordpress/compose'

function addCustomAttributes (settings, name) {
  if (name !== 'core/cover') {
    return settings
  }
  if (settings.attributes) {

    settings.attributes.innerBackgroundColor = {
      type:    'string',
      default: ''
    }

  }
  return settings
}

addFilter('blocks.registerBlockType', 'cover-gravity-forms/filterBlockAttributes', addCustomAttributes)
const COVER_VARIATION_CLASSNAME = 'wp-block-gravity-forms-cover'

registerBlockVariation('core/cover', {
  name:        'cover-gravity-forms',
  title:       __('Gravity forms cover', 'cloudweb-landing-page'),
  description: __('Displays a form with a cover image', 'cloudweb-landing-page'),
  icon:        (
                 <Icon
                   icon={() => (
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                       <path
                         d="M24 32H0v48h32v352H0v48h512v-48h-32V80h32V32H24zm56 400V80h352v352H80zM272 96h-32v48h-80v32h80v32H128v32h112v54.6L181.3 272H128v57.6l42.7 54.4h170.6l42.7-54.4V272h-53.3L272 294.6V240h112v-32H272v-32h80v-32h-80V96zm-64 224a16 16 0 110 32 16 16 0 110-32zm80 16a16 16 0 1132 0 16 16 0 11-32 0z"></path>
                     </svg>
                   )}
                 />
               ),
  isActive:    (blockAttributes, variationAttributes) =>
                 blockAttributes.className === variationAttributes.className,
  keywords:    ['gravity', 'forms'],
  isDefault:   true,
  attributes:  {
    className: COVER_VARIATION_CLASSNAME,
    dimRatio:  0.5,
    align:     'full',
    url:       window.l18n_js_landing_page.cover_bg,
  },
  innerBlocks: [
    [
      'core/heading',
      {
        'placeholder': 'Cover heading',
        'textAlign':   'center'
      },
    ],
    [
      'core/paragraph',
      {
        'placeholder': 'Cover sub headline',
        'align':       'center'
      },
    ],
    [
      'gravityforms/form',
      {
        'formId':            '',
        'inputPrimaryColor': '#204ce5',
      },
    ],
  ],
})

const isCloudWebCoverVariation = (props) => {
  const {
    attributes: {className},
  } = props
  return className && className === COVER_VARIATION_CLASSNAME
}

const CloudWebCoverControls = (props) => {
  const {
    attributes: {innerBackgroundColor},
    setAttributes,
    clientId
  } = props
  return (
    <ToolsPanelItem
      label={__('GForm Container Background Color', 'cloudweb-landing-page')}
      hasValue={() => {
        return innerBackgroundColor ? true : false
      }}
      panelId={clientId}
      isShownByDefault={true}
      resetAllFilter={() => ({
        innerBackgroundColor: undefined,
      })}
    >
      <Text variant="label" lineHeight="40px">{__('GForm Container Background Color', 'cloudweb-landing-page')}</Text>
      <ColorPicker
        color={innerBackgroundColor}
        onChange={(color) => {
          setAttributes({innerBackgroundColor: color})
        }}
        onChangeComplete={(color) => {
          setAttributes({
            innerBackgroundColor: `rgba(${color.rgb.r},${color.rgb.g},${color.rgb.b},${color.rgb.a})`,
          })
        }}
        enableAlpha={true}
      />
    </ToolsPanelItem>
  )
}

export const withCloudWebCoverControls = (BlockEdit) => (props) => {
  return isCloudWebCoverVariation(props) ? (
    <>
      <BlockEdit {...props} />
      <InspectorControls group="color">
        <CloudWebCoverControls {...props} />
      </InspectorControls>
    </>
  ) : (
    <BlockEdit {...props} />
  )
}

addFilter('editor.BlockEdit', 'core/cover', withCloudWebCoverControls)

function addBackgroundColorStyle (props, block, attributes) {

  if (block.name !== 'core/cover') {
    return props
  }
  if (props.className.includes('wp-block-gravity-forms-cover') === false) {
    return props
  }
  const {style} = props,
    backgroundVar = attributes?.innerBackgroundColor ? {'--wp-block-gravity-forms-cover--background': attributes?.innerBackgroundColor} : {},
    newStyle = {...style, ...backgroundVar}
  return {
    ...props,
    style: {...newStyle},
  }
}

addFilter(
  'blocks.getSaveContent.extraProps',
  'cloudweb-landing-page/add-background-color-style',
  addBackgroundColorStyle
)

const withCustomAttribute = createHigherOrderComponent((BlockListBlock) => {
  return (props) => {
    const {attributes, block} = props

    if (block.name !== 'core/cover') {
      return <BlockListBlock {...props}/>
    }

    if (props?.attributes?.className.includes('wp-block-gravity-forms-cover') === false) {
      return <BlockListBlock {...props}/>
    }
    const {innerBackgroundColor} = attributes
    return <BlockListBlock {...props}
                           wrapperProps={{style: {'--wp-block-gravity-forms-cover--background': innerBackgroundColor}}}/>
  }
}, 'withCustomAttribute')

addFilter(
  'editor.BlockListBlock',
  'cloudweb-landing-page/width-custom-attribute',
  withCustomAttribute
)