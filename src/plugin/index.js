/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { registerPlugin } from '@wordpress/plugins'
import { useEntityProp, store as coreStore } from '@wordpress/core-data'
import { useDispatch, useSelect } from '@wordpress/data'
import { PluginDocumentSettingPanel as DocumentSettingPanel } from '@wordpress/edit-post'
import { compose } from '@wordpress/compose'
import {
  Button,
  Spinner,
  ResponsiveWrapper,
  BaseControl,
  ColorPicker,
  __experimentalHStack as HStack,
  DropZone,
  withNotices, PanelBody, PanelRow, Panel, Icon,
} from '@wordpress/components'
import {
  MediaUpload,
  MediaUploadCheck,
  store as blockEditorStore,
} from '@wordpress/block-editor'
import { useRef, useState } from '@wordpress/element'
import { isBlobURL } from '@wordpress/blob'

/**
 * Internal dependencies
 */

import icon from './components/icon'

const Render = ({noticeUI, noticeOperations}) => {
  // const postType = useSelect(
  //   (select) => select('core/editor').getCurrentPostType(),
  //   []
  // )
  // const postId = useSelect((select) => select('core/editor').getCurrentPostId(), [])
  const [isLoading, setIsLoading] = useState(false)
  const {saveEntityRecord} = useDispatch('core')

  const [pluginSettings, setPluginSettings] = useEntityProp(
    'root',
    'site',
    'cloudweb-landing-page-settings_data'
  )

  // console.log('pluginSettings', pluginSettings)

  const metaMediaId = pluginSettings?._logo
  const mediaUpload = useSelect((select) => {
    return select(blockEditorStore).getSettings().mediaUpload
  }, [])
  // const {savePost} = useDispatch(editorStore)
  const logoImageButton = useRef()
  const instructions = (
    <p>
      {__(
        'To add or edit logo image, you need permission to upload media.',
        'cloudweb-landing-page'
      )}
    </p>
  )
  const logoImage = useSelect((select) => {
    return select(coreStore).getMedia(metaMediaId)
  })

  const settingBGColor = pluginSettings?._bg_color

  const handleSaveSettings = async () => {
    await saveEntityRecord('root', 'site', {
      'cloudweb-landing-page-settings_data': {
        ...pluginSettings,
      },
    })
  }

  const updateLogo = (mediaId) => {
    setPluginSettings({
      ...pluginSettings,
      _logo: parseInt(mediaId),
    })
    handleSaveSettings()
  }

  const updateBGColor = (color) => {
    setPluginSettings({
      ...pluginSettings,
      _bg_color: color,
    })
    handleSaveSettings()
  }

  const onRemoveImage = () => {
    setPluginSettings({...pluginSettings, _logo: null})
  }

  function onDropFiles (filesList) {
    mediaUpload({
      allowedTypes: ['image'],
      filesList,
      onFileChange ([image]) {
        if (isBlobURL(image?.url)) {
          setIsLoading(true)
          return
        }
        updateLogo(image.id)
        setIsLoading(false)
      },
      onError (message) {
        noticeOperations.removeAllNotices()
        noticeOperations.createErrorNotice(message)
      },
    })
  }

  return (
    <DocumentSettingPanel
      name="landing-page-settings"
      title={__('Landing Page Settings', 'cloudweb-landing-page')}
      className="landing-page-settings"
      icon={settingBGColor ? <Icon icon={<div className={'bg_color_icon'} style={{
        backgroundColor: settingBGColor,
        height:          '20px',
        width:           '20px'
      }}/>}/> : ''}
    >
      <Panel>
        <PanelBody title="Logo" initialOpen={false}>
          <PanelRow>
            <BaseControl className="sidebar-logo-image-control">
              <MediaUploadCheck fallback={instructions}>
                <MediaUpload
                  title={__('Select Logo', 'cloudweb-landing-page')}
                  unstableFeaturedImageFlow
                  modalClass="editor-post-featured-image__media-modal"
                  onSelect={(media) => {
                    updateLogo(media.id)
                    // Move focus back to the Media Upload button.
                    logoImageButton.current.focus()
                  }}
                  allowedTypes={['image']}
                  render={({open}) => (
                    <div className="editor-post-featured-image__container">
                      <Button
                        className={
                          !logoImage
                            ? 'editor-post-featured-image__toggle'
                            : 'editor-post-featured-image__preview'
                        }
                        onClick={open}
                        ref={logoImageButton}
                        aria-label={
                          !(metaMediaId === 0 || metaMediaId == null)
                            ? null
                            : __('Edit or replace logo', 'cloudweb-landing-page')
                        }
                        aria-describedby={
                          !(metaMediaId === 0 || metaMediaId == null)
                            ? null
                            : `editor-post-featured-image-${metaMediaId}-describedby`
                        }
                      >
                        {(metaMediaId === 0 || metaMediaId == null) &&
                          !isLoading &&
                          __('Select Logo', 'cloudweb-landing-page')}
                        {metaMediaId > 0 && logoImage === undefined && (
                          <Spinner/>
                        )}
                        {isLoading && <Spinner/>}
                        {logoImage && (
                          <>
                            {isBlobURL(logoImage?.source_url) && <Spinner/>}
                            <ResponsiveWrapper
                              naturalWidth={logoImage.media_details.width}
                              naturalHeight={logoImage.media_details.height}
                            >
                              <img
                                src={logoImage?.source_url}
                                alt={__('Logo image', 'cloudweb-landing-page')}
                              />
                            </ResponsiveWrapper>
                          </>
                        )}
                      </Button>
                      {logoImage && (
                        <HStack className="editor-post-featured-image__actions">
                          <Button
                            className="editor-post-featured-image__action"
                            onClick={open}
                            // Prefer that screen readers use the .editor-post-featured-image__preview button.
                            aria-hidden="true"
                          >
                            {__('Replace', 'cloudweb-landing-page')}
                          </Button>
                          <Button
                            className="editor-post-featured-image__action"
                            onClick={() => {
                              onRemoveImage()
                              logoImageButton.current.focus()
                            }}
                          >
                            {__('Remove', 'cloudweb-landing-page')}
                          </Button>
                        </HStack>
                      )}
                      <DropZone onFilesDrop={onDropFiles}/>
                    </div>
                  )}
                />
              </MediaUploadCheck>
            </BaseControl>
          </PanelRow>
        </PanelBody>
      </Panel>
      <Panel>
        <PanelBody title="Header Background Color">
          <PanelRow>
            <BaseControl className="sidebar-background-control">
              <ColorPicker
                color={settingBGColor}
                onChange={(color) => {
                  updateBGColor(color)
                }}
                onChangeComplete={(color) => {
                  const theColor = `rgba(${color.rgb.r},${color.rgb.g},${color.rgb.b},${color.rgb.a})`
                  updateBGColor(theColor)
                  // setAttributes({
                  //   innerBackgroundColor: `rgba(${color.rgb.r},${color.rgb.g},${color.rgb.b},${color.rgb.a})`,
                  // })
                }}
                enableAlpha={true}
              />
            </BaseControl>
          </PanelRow>
        </PanelBody>
      </Panel>

    </DocumentSettingPanel>
  )
}

registerPlugin('cloudweb-landing-page-plugin', {
  icon,
  // render: Render,
  render: compose(withNotices)(Render),
})
