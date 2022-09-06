<?php

/**
 * Declare common (backend|frontend) global functions here
 * but try not to use any global functions unless you need.
 */

use FluentForm\App\Modules\Component\BaseComponent as FluentFormComponent;
use FluentForm\App\Services\FormBuilder\EditorShortCode;
use FluentForm\Framework\Helpers\ArrayHelper;

if (!function_exists('wpFluentForm')) {
    function wpFluentForm($key = null)
    {
        return FluentForm\App::make($key);
    }
}

if (!function_exists('wpFluentFormAddComponent')) {
    function wpFluentFormAddComponent(FluentFormComponent $component)
    {
        return $component->_init();
    }
}

if (!function_exists('dd')) {
    function dd()
    {
        foreach (func_get_args() as $value) {
            echo "<pre>";
            print_r($value);
            echo "</pre><br>";
        }
        die;
    }
}

if (!function_exists('fluentformMix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     *
     * @return string
     * @throws \Exception
     */
    function fluentformMix($path, $manifestDirectory = '')
    {
        $publicUrl = \FluentForm\App::publicUrl();
        return $publicUrl . $path;
    }
}

if (!function_exists('fluentFormSanitizer')) {
    /**
     * Sanitize form inputs recursively.
     *
     * @param $input
     *
     * @return string $input
     */
    function fluentFormSanitizer($input, $attribute = null, $fields = [])
    {
        if (is_string($input)) {
            if (ArrayHelper::get($fields, $attribute . '.element') === 'post_content'  || ArrayHelper::get($fields, $attribute . '.element') === 'rich_text_input' ) {
                return wp_kses_post($input);
            } elseif (ArrayHelper::get($fields, $attribute . '.element') === 'textarea') {
                $input = sanitize_textarea_field($input);
            } elseif (ArrayHelper::get($fields, $attribute . '.element') === 'input_email') {
                $input = strtolower(sanitize_text_field($input));
            } elseif (ArrayHelper::get($fields, $attribute . '.element') === 'input_url') {
                $input = sanitize_url($input);
            } else {
                $input = sanitize_text_field($input);
            }
        } elseif (is_array($input)) {
            foreach ($input as $key => &$value) {
                $attribute = $attribute ? $attribute . '[' . $key . ']' : $key;

                $value = fluentFormSanitizer($value, $attribute, $fields);

                $attribute = null;
            }
        }

        return $input;
    }
}

if (!function_exists('fluentFormEditorShortCodes')) {
    function fluentFormEditorShortCodes()
    {
        return apply_filters('fluentform_editor_shortcodes', [
            EditorShortCode::getGeneralShortCodes()
        ]);
    }
}

if (!function_exists('fluentFormGetAllEditorShortCodes')) {
    function fluentFormGetAllEditorShortCodes($form)
    {
        return apply_filters(
            'fluentform_all_editor_shortcodes',
            EditorShortCode::getShortCodes($form),
            $form
        );
    }
}

if (!function_exists('fluentImplodeRecursive')) {
    /**
     * Recursively implode a multi-dimentional array
     * @param string $glue
     * @param array $array
     * @return string
     */
    function fluentImplodeRecursive($glue, array $array)
    {
        $fn = function ($glue, array $array) use (&$fn) {
            $result = '';
            foreach ($array as $item) {
                if (is_array($item)) {
                    $result .= $fn($glue, $item);
                } else {
                    $result .= $glue . $item;
                }
            }
            return $result;
        };

        return ltrim($fn($glue, $array), $glue);
    }
}


function fluentform_get_active_theme_slug()
{
    if ($ins = get_option('_ff_ins_by')) {
        return sanitize_text_field($ins);
    }

    if (defined('TEMPLATELY_FILE')) {
        return 'templately';
    }
    return get_option('template');
}

if (!function_exists('getFluentFormCountryList')) {
    function getFluentFormCountryList()
    {
        static $countries = null;
        if (is_null($countries)) {
            $countries = require(
            FluentForm\App::appPath('/Services/FormBuilder/CountryNames.php')
            );
        }
        return $countries;
    }
}

if (!function_exists('fluentFormWasSubmitted')) {
    function fluentFormWasSubmitted($action = 'fluentform_submit')
    {
        return wpFluentForm('request')->get('action') == $action;
    }
}

if (!function_exists('isWpAsyncRequest')) {
    function isWpAsyncRequest($action)
    {
        return strpos(wpFluentForm('request')->get('action'), $action) !== false;
    }
}

if (!function_exists('fluentFormIsHandlingSubmission')) {
    function fluentFormIsHandlingSubmission()
    {
        $status = fluentFormWasSubmitted() || isWpAsyncRequest('fluentform_async_request');
        return apply_filters('fluentform_is_handling_submission', $status);
    }
}

function fluentform_mb_strpos($haystack, $needle)
{
    if (function_exists('mb_strpos')) {
        return mb_strpos($haystack, $needle);
    }
    return strpos($haystack, $needle);
}

function fluentFormHandleScheduledTasks()
{
    // Let's run the feed actions
    $handler = new \FluentForm\App\Services\WPAsync\FluentFormAsyncRequest(wpFluentForm());
    $handler->processActions();

    $rand = mt_rand(1, 10);
    if ($rand >= 7) {
        do_action('fluentform_maybe_scheduled_jobs');
    }
}

function fluentFormHandleScheduledEmailReport()
{
    \FluentForm\App\Services\Scheduler\Scheduler::processEmailReport();
}

function fluentform_upgrade_url()
{
    return 'https://fluentforms.com/pricing/?utm_source=plugin&utm_medium=wp_install&utm_campaign=ff_upgrade&theme_style=' . fluentform_get_active_theme_slug();
}

function fluentFormApi($module = 'forms')
{
    if ($module == 'forms') {
        return (new \FluentForm\App\Api\Form());
    } elseif ($module == 'submissions') {
        return (new \FluentForm\App\Api\Submission());
    }

    throw new \Exception('No Module found with name '. $module);
}

function fluentFormGetRandomPhoto()
{
    $photos = [
        'demo_1.jpg',
        'demo_2.jpg',
        'demo_3.jpg',
        'demo_4.jpg',
        'demo_5.jpg'
    ];

    $selected = array_rand($photos, 1);

    $photoName = $photos[$selected];

    return fluentformMix('img/conversational/' . $photoName);
}

if (! function_exists('fluentFormRender')) {
    function fluentFormRender($atts)
    {
        $shortcodeDefaults = array(
            'id'                 => null,
            'title'              => null,
            'css_classes'        => '',
            'permission'         => '',
            'type'               => 'classic',
            'permission_message' => __('Sorry, You do not have permission to view this form', 'fluentform')
        );
        $atts = shortcode_atts($shortcodeDefaults, $atts);

        return (new \FluentForm\App\Modules\Component\Component(wpFluentForm()))->renderForm($atts);
    }
}

/**
 * Print internal content (not user input) without escaping.
 */
function fluentFormPrintUnescapedInternalString($string)
{
    echo $string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}


function fluentform_options_sanitize($options)
{
    $maps = [
        'label' => 'wp_kses_post',
        'value' => 'sanitize_text_field',
        'image' => 'sanitize_url',
        'calc_value' => 'sanitize_text_field'
    ];

    $mapKeys = array_keys($maps);

    foreach ($options as $optionIndex => $option) {
        $attributes  = array_filter(\FluentForm\Framework\Helpers\ArrayHelper::only($option, $mapKeys));
        foreach ($attributes as $key => $value) {
            $options[$optionIndex][$key] = call_user_func($maps[$key], $value);
        }
    }

    return $options;
}

function fluentform_sanitize_html($html)
{
    if (!$html) {
        return $html;
    }

    $tags = wp_kses_allowed_html('post');
    $tags['style'] = [
        'types' => [],
    ];
    // iframe
    $tags['iframe'] = [
        'width'           => [],
        'height'          => [],
        'src'             => [],
        'srcdoc'          => [],
        'title'           => [],
        'frameborder'     => [],
        'allow'           => [],
        'class'           => [],
        'id'              => [],
        'allowfullscreen' => [],
        'style'           => [],
    ];
    //button
    $tags['button']['onclick'] = [];

    //svg
    if (empty($tags['svg'])) {
        $svg_args = array(
            'svg'   => array(
                'class'           => true,
                'aria-hidden'     => true,
                'aria-labelledby' => true,
                'role'            => true,
                'xmlns'           => true,
                'width'           => true,
                'height'          => true,
                'viewbox'         => true, // <= Must be lower case!
            ),
            'g'     => array('fill' => true),
            'title' => array('title' => true),
            'path'  => array(
                'd'    => true,
                'fill' => true,
            )
        );
        $tags = array_merge($tags, $svg_args);
    }

    $tags = apply_filters('fluentform_allowed_html_tags', $tags);

    return wp_kses($html, $tags);
}

if (!function_exists('fluentform_backend_sanitizer')) {
    /**
     * Sanitize inputs recursively.
     *
     * @param array $input
     * @param array $sanitizeMap
     * @return array $input
     */
    function fluentform_backend_sanitizer($array, $sanitizeMap = [])
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = fluentform_backend_sanitizer($value, $sanitizeMap);
            } else {
                $method = ArrayHelper::get($sanitizeMap, $key);
    
                if (is_callable($method)) {
                    $value = call_user_func($method, $value);
                }
            }
        }
    
        return apply_filters('fluent_backend_sanitized_values', $array);
    }
}
