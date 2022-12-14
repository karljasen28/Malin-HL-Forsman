<?php

namespace FluentForm\App\Services\FormBuilder\Components;

class Recaptcha extends BaseComponent
{
	/**
	 * Compile and echo the html element
	 * @param  array $data [element data]
	 * @param  stdClass $form [Form Object]
	 * @return viod
	 */
	public function compile($data, $form)
	{
        $elementName = $data['element'];
        $data = apply_filters('fluentform_rendering_field_data_'.$elementName, $data, $form);


		$key = get_option('_fluentform_reCaptcha_details');
		$apiVersion = 'v2_visible';
		if($key && isset($key['siteKey'])) {
			$siteKey = $key['siteKey'];
		} else {
			$siteKey = '';
		}

		if(!$siteKey) {
		    return false;
        }

		if(!empty($key['api_version'])) {
            $apiVersion = $key['api_version'];
        }

		if($apiVersion == 'v3_invisible') {
            wp_enqueue_script(
                'google-recaptcha',
                'https://www.google.com/recaptcha/api.js?render='.$siteKey,
                array(),
                FLUENTFORM_VERSION,
                true
            );

            add_filter('fluentform_form_class', function ($formClass) {
                $formClass .= ' ff_has_v3_recptcha';
                return $formClass;
            });

            add_filter('fluent_form_html_attributes', function ($atts) use ($siteKey) {
                $atts['data-recptcha_key'] = $siteKey;
                return $atts;
            });

            return ;
        }

        wp_enqueue_script(
            'google-recaptcha',
            'https://www.google.com/recaptcha/api.js',
            array(),
            FLUENTFORM_VERSION,
            true
        );

		$recaptchaBlock = "<div
		data-sitekey='{$siteKey}'
		id='fluentform-recaptcha-{$form->id}'
		class='ff-el-recaptcha g-recaptcha'
		data-callback='fluentFormrecaptchaSuccessCallback'></div>";

		$label = '';
		if (!empty($data['settings']['label'])) {
			$label = "<div class='ff-el-input--label'><label>{$data['settings']['label']}</label></div>";
		}
		
		$containerClass = '';
		if (!empty($data['settings']['label_placement'])) {
			$containerClass = 'ff-el-form-' . $data['settings']['label_placement'];
		}

		$el = "<div class='ff-el-input--content'><div data-fluent_id='".$form->id."' name='g-recaptcha-response'>{$recaptchaBlock}</div></div>";
		
		$html = "<div class='ff-el-group {$containerClass}' >{$label}{$el}</div>";
        fluentFormPrintUnescapedInternalString( apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form) );
    }
}
