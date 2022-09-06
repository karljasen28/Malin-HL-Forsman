<?php

namespace FluentForm\App\Modules\Widgets;

use FluentForm\App\Helpers\Helper;

class OxyFluentFormWidget extends OxygenEl
{
    public $css_added = false;

    public function name()
    {
        return __('Fluent Form', 'fluentform');
    }

    public function slug()
    {
        return "form_widget";
    }

    public function accordion_button_place()
    {
        return "form";
    }

    public function icon()
    {
        return '';
    }

    public function controls()
    {
        $templates_control = $this->addOptionControl(
            array(
                'type'    => 'dropdown',
                'name'    => __('Select a Form', 'fluentform'),
                'slug'    => 'ff_form',
                'value'   => Helper::getForms(),
                'default' => "no",
                "css"     => false
            )
        );
        $templates_control->rebuildElementOnChange();

        $this->formContainerStyleControls();
        $this->formInputLabelsStyle();
        $this->formInputsStyle();
        $this->checkboxAndRadioStyle();
        $this->gdprAndTermsConditionStyle();
        $this->sectionBreakStyle();
        $this->checkboxGridStyle();
        $this->fileUploadStyle();
        $this->progressBarStyle();
        $this->submitBtnStyle();
        $this->stepButtonStyle();
        $this->successMessageStyle();
        $this->errorMessageStyle();
    }

    public function formContainerStyleControls()
    {
        $section_container = $this->addControlSection("fluentform_container", __("Form Container", "fluentform"),
            "assets/icon.png", $this);
        $selector = '.fluentform';
        $section_container->addStyleControls(
            array(
                array(
                    "name"     => __('Background Color', 'fluentform'),
                    "selector" => $selector,
                    "property" => 'background-color'
                ),
                array(
                    "name"     => __('Max Width', "fluentform"),
                    "selector" => $selector,
                    "property" => 'width',
                )
            )
        );


        $section_container->addPreset(
            "padding",
            "fluentform_container_padding",
            __("Padding", 'fluentform'),
            $selector
        )->whiteList();

        $section_container->addPreset(
            "margin",
            "fluentform_container_margin",
            __("Margin", 'fluentform'),
            $selector
        )->whiteList();

        $section_container->addPreset(
            "border",
            "fluentform_container_border",
            __("Border", 'fluentform'),
            $selector
        )->whiteList();

        $section_container->addPreset(
            "border-radius",
            "fluentform_container_radius",
            __("Border Radius", 'fluentform'),
            $selector
        )->whiteList();

        $section_container->boxShadowSection(
            __("Box Shadow", 'fluentform'),
            $selector
            , $this);
    }

    public function formInputLabelsStyle()
    {
        $section_label = $this->addControlSection("fluentform_label", __("Labels", "fluentform"),
            "assets/icon.png", $this);

        $selector = '.fluentform .ff-el-input--label label';
        $section_label->typographySection(__('Typography'), $selector, $this);
        $section_label->addStyleControls(
            array(
                array(
                    "name"     => __('Text Color', 'fluentform'),
                    "selector" => $selector,
                    "property" => 'color'
                )
            )
        );
        $section_label->addStyleControl(
            array(
                "name"     => __('Asterisk Color', 'fluentform'),
                "selector" => '.ff-el-input--label.ff-el-is-required.asterisk-right label:after ,.ff-el-input--label.ff-el-is-required.asterisk-left label:before',
                "property" => 'color',
            )
        );
    }

    public function formInputsStyle()
    {
        $selector = '.ff-el-form-control';
        $section_input = $this->addControlSection("fluentform_input", __("Input & Textara", "fluentform"),
            "assets/icon.png", $this);

        $section_input->addStyleControls(
            array(
                array(
                    "name"         => __('Text Indent', "fluentform"),
                    "selector"     => $selector,
                    "property"     => 'padding-left',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                ),
                array(
                    "name"     => __('Margin Bottom'),
                    "selector" => '.ff-el-group',
                    "property" => 'margin-bottom'
                ),
                array(
                    "name"         => __('Input Width', "fluentform"),
                    "selector"     => $selector,
                    "property"     => 'width',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                ),
                array(
                    "name"         => __('Input Height', "fluentform"),
                    "selector"     => $selector,
                    "property"     => 'height',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                ),
                array(
                    "name"         => __('Textarea Width', "fluentform"),
                    "selector"     => '.ff-el-group textarea',
                    "property"     => 'width',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                ),
                array(
                    "name"         => __('Textarea Height', "fluentform"),
                    "selector"     => '.ff-el-group textarea',
                    "property"     => 'height',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                )
            )
        );

        $section_input_normal = $section_input->addControlSection("fluentform_input_normal_section",
            __("Normal", "fluentform"), "assets/icon.png", $this);

        $section_input_normal->addStyleControls(
            array(
                array(
                    "name"     => __('Color'),
                    "selector" => '.ff-el-form-control',
                    "property" => 'color'
                ),
                array(
                    "name"     => __('Background Color'),
                    "selector" => '.ff-el-form-control',
                    "property" => 'background-color'
                ),
                array(
                    "name"     => __('Placeholder Color'),
                    "slug"     => "fluentform_input_placeholder",
                    "selector" => '::placeholder',
                    "property" => 'color'
                )
            )
        );

        $section_input_hover = $section_input->addControlSection("fluentform_input_hover_section",
            __("Hover", "fluentform"), "assets/icon.png", $this);

        $section_input_hover->addStyleControls(
            array(
                array(
                    "name"     => __('Background Color'),
                    "selector" => '.ff-el-form-control:focus',
                    "property" => 'background-color'
                ),
                array(
                    "name"     => __('Text Color'),
                    "selector" => '.ff-el-form-control:focus',
                    "property" => 'color'
                ),
                array(
                    "name"         => __('Border Color'),
                    "selector"     => '.ff-el-form-control:focus',
                    "property"     => 'border-color',
                    "control_type" => 'colorpicker'
                )
            )
        );


        $section_input->addPreset(
            "padding",
            "fluentform_input_spacing",
            __("Padding", 'fluentform'),
            $selector
        )->whiteList();

        $section_input->boxShadowSection(
            __("Box Shadow", 'fluentform'),
            $selector
            , $this);

        $section_input->typographySection(
            __('Typography'),
            $selector
            , $this);

        $section_input->addPreset(
            "border",
            "fluentform_input_border",
            __("Border", 'fluentform'),
            $selector
        )->whiteList();

        $section_input->addPreset(
            "border-radius",
            "fluentform_input_border_radius",
            __("Border Radius", 'fluentform'),
            $selector
        )->whiteList();
    }

    public function checkboxGridStyle()
    {
        $section_checkbox_grid = $this->addControlSection("fluentform_checkbox_grid",
            __("Checkable Grid Field", "fluentform"),
            "assets/icon.png", $this);

        $section_checkbox_grid_spacing = $section_checkbox_grid->addControlSection("fluentform_checkbox_grid_sp",
            __("Spacing", "fluentform"),
            "assets/icon.png", $this);
        $section_checkbox_grid_width = $section_checkbox_grid_spacing->addStyleControl(
            array(
                "selector"     => '.fluentform .ff-checkable-grids',
                "property"     => 'width',
                'control_type' => 'slider-measurebox'
            )
        );
        $section_checkbox_grid_width->setRange('0', '100', '1');
        $section_checkbox_grid_width->setUnits('%', 'px,%,em');
        $section_checkbox_grid_width->setDefaultValue('100');

        $section_checkbox_grid_spacing->addPreset(
            "padding",
            "fluentform_checkbox_grid_padding",
            __("Table Head Cell Padding"),
            ".fluentform .ff-checkable-grids thead>tr>th"
        )->whiteList();

        $section_checkbox_grid_spacing->addPreset(
            "padding",
            "fluentform_checkbox_grid_padding_tb",
            __("Table Body Cell Padding"),
            ".fluentform .ff-checkable-grids tbody>tr>td"
        )->whiteList();

        $section_checkbox_grid_color = $section_checkbox_grid->addControlSection("fluentform_checkbox_grid_color",
            __("Color", "fluentform"),
            "assets/icon.png", $this);
        $section_checkbox_grid_color->addStyleControls([
            array(
                "name"     => __('Table Outer Border Width', "fluentform"),
                "selector" => '.fluentform .ff-checkable-grids',
                "property" => 'border-width'
            ),
            array(
                "name"     => __('Table Outer Border Color', "fluentform"),
                "selector" => '.fluentform .ff-checkable-grids',
                "property" => 'border-color'
            ),
            array(
                "name"     => __('Table Head Background', "fluentform"),
                "selector" => '.fluentform .ff-checkable-grids thead>tr>th',
                "property" => 'background-color'
            ),
            array(
                "name"     => __('Table Body Background', "fluentform"),
                "selector" => '.fluentform .ff-checkable-grids tbody>tr>td',
                "property" => 'background-color'
            ),
            array(
                "name"     => __('Table Body Alt Background', "fluentform"),
                "selector" => '.fluentform .ff-checkable-grids tbody>tr:nth-child(2n)>td',
                "property" => 'background-color'
            ),
            array(
                "name"     => __('Table Body Alt Text Color', "fluentform"),
                "selector" => '.fluentform .ff-checkable-grids tbody>tr:nth-child(2n)>td',
                "property" => 'color'
            )
        ]);

        $section_checkbox_grid->typographySection(__("Heading Typography", "fluentform"),
            ".fluentform .ff-checkable-grids thead>tr>th", $this);
        $section_checkbox_grid->typographySection(__("Cell Typography", "fluentform"),
            ".fluentform .ff-checkable-grids tbody>tr>td",
            $this);
    }

    public function gdprAndTermsConditionStyle()
    {
        $section_gdpr_terms = $this->addControlSection("fluentform_gdpr_terms_section",
            __("GDPR, Terms & Condition", "fluentform"),
            "assets/icon.png", $this);

        $section_gdpr_terms->typographySection(__('Typography'), '.ff-el-tc , .ff_t_c', $this);
        $section_gdpr_terms->addStyleControls(
            array(
                array(
                    "name"     => __('Text Color', 'fluentform'),
                    "selector" => '.ff-el-tc , .ff_t_c',
                    "property" => 'color'
                ),
                array(
                    "name"     => __('Link Color', 'fluentform'),
                    "selector" => '.ff-el-tc a, .ff_t_c a',
                    "property" => 'color'
                )
            )
        );
    }

    public function sectionBreakStyle()
    {
        $section_section_break = $this->addControlSection("fluentform_section_break_section",
            __('Section Break', 'fluentform'),
            "assets/icon.png", $this);

        $selector = '.ff-el-section-break';
        $section_section_break->typographySection(__('Typography','fluentform'), $selector, $this);
        $section_section_break->addStyleControls(
            array(
                array(
                    "name"     => __('Text Color', 'fluentform'),
                    "selector" => $selector,
                    "property" => 'color'
                ),
                array(
                    "selector" => $selector,
                    "slug"     => 'ff_section_break_section_bg_color',
                    "property" => 'background-color'
                )
            )
        );
        $section_section_break->addPreset(
            "padding",
            "ff_section_break_section_padding",
            __('Padding', 'fluentform'),
            $selector
        )->whiteList();

        $section_section_break->addPreset(
            "margin",
            "ff_section_break_section_margin",
            __('Margin', 'fluentform'),
            $selector
        )->whiteList();


        $section_section_break->addStyleControl(
            array(
                "selector" => $selector . ' hr',
                "slug"     => 'ffsb_line',
                "property" => 'border-color'
            )
        )->setParam('hide_wrapper_end', true);

        $section_section_break->addStyleControl(
            array(
                "selector" => $selector . ' hr',
                "slug"     => 'ffsb_linew',
                "property" => 'border-width'
            )
        )->setParam('hide_wrapper_start', true);
    }

    public function render($options, $defaults, $content)
    {
        if ($options['ff_form'] == "no") {
            echo '<h5 class="ff-template-missing">' . __('Select a Form', 'fluentform') . '</h5>';
            return;
        }

        if (function_exists('do_oxygen_elements')) {
            echo do_oxygen_elements('[fluentform id="' . $options['ff_form'] . '"]');
        } else {
            if (Helper::isConversionForm($options['ff_form'])) {
                _e("This is a Conversational Form. You must use the default Design tab for this type of forms.", 'fluentform');
                return;
            }
            echo do_shortcode('[fluentform id="' . $options['ff_form'] . '"]');
        }
    }

    public function init()
    {
        $this->El->useAJAXControls();
        if (isset($_GET['ct_builder'])) {
            $app = wpFluentForm();
            wp_enqueue_style(
                'fluent-form-styles',
                $app->publicUrl('css/fluent-forms-public.css'),
                array(),
                FLUENTFORM_VERSION
            );

            wp_enqueue_style(
                'fluentform-public-default',
                $app->publicUrl('css/fluentform-public-default.css'),
                array(),
                FLUENTFORM_VERSION
            );

            if ( ! wp_script_is('flatpickr', 'registered')) {
                wp_enqueue_style(
                    'flatpickr',
                    $app->publicUrl('libs/flatpickr/flatpickr.min.css')
                );
            }

            wp_enqueue_style(
                'ff_choices',
                $app->publicUrl('css/choices.css'),
                [],
                FLUENTFORM_VERSION
            );
        }
    }

    public function enablePresets()
    {
        return true;
    }

    public function enableFullPresets()
    {
        return true;
    }

    public function customCSS($options, $selector)
    {
        $css = $defaultCSS = '';

        $prefix = 'oxy-' . $this->slug();

        if (isset($options[$prefix . '_ff_inp_placeholder'])) {
            $css .= '.fluent_form_' . $options['fluentform'] . ' .ff-el-form-control::-webkit-input-placeholder,.fluent_form_' . $options['fluentform'] . ' .ff-el-form-control::-moz-input-placeholder,.fluent_form_' . $options['fluentform'] . ' .ff-el-form-control:-ms-input-placeholder,.fluent_form_' . $options['fluentform'] . ' .ff-el-form-control::placeholder{color:' . $options['ff_inp_placeholder'] . ';}';
        }

        if (isset($options[$prefix . '_rc_smart_ui']) && $options[$prefix . '_rc_smart_ui'] == "yes") {
            $css .= $selector . " .ff-el-group input[type=checkbox]:after, " . $selector . " .ff-el-group input[type=radio]:after {content: \" \"!important;display: inline-block!important;border-style: solid}";
            $css .= $selector . " .ff-el-group input[type=checkbox], " . $selector . " .ff-el-group input[type=radio]{width: 1px;}";
        } else {
            $css .= $selector . " .ff-el-group input[type=checkbox]:after, " . $selector . " .ff-el-group input[type=radio]:after {content: none;}";
        }

        return $defaultCSS . $css;
    }

    public function checkboxAndRadioStyle()
    {
        $input_section_radio_checkbox = $this->addControlSection("fluentform_checkbox_radio_style",
            __("Checkbox & Radio", "fluentform"), "assets/icon.png", $this);
        $selector_after = '.ff-el-group input[type=checkbox]:after,.ff-el-group input[type=radio]:after';
        $selector = '.ff-el-group input[type=checkbox],.ff-el-group input[type=radio]';


        $text = $input_section_radio_checkbox->addControlSection("fluentform_radio_checkbox_text",
            __('Text Style', 'fluentform'), "assets/icon.png", $this);

        $text->addStyleControls(
            array(
                array(
                    'selector' => '.ff-el-form-check-label, .ff_t_c',
                    'property' => 'color',
                    'name'     => __('Text Color','fluentform')
                ),
                array(
                    'selector' => '.ff_t_c a',
                    'property' => 'color',
                    'name'     => __('Link Color','fluentform')
                ),
                array(
                    'selector' => '.ff_t_c a:hover',
                    'property' => 'color',
                    'name'     => __('Link Hover Color','fluentform')
                ),
                array(
                    'selector'     => '.ff-el-form-check-label, .ff_t_c',
                    'property'     => 'font-size',
                    "control_type" => 'slider-measurebox',
                    'name'         => __('Text Font Size','fluentform'),
                    'unit'         => 'px'
                )
            )
        );

        $smart_ui = $input_section_radio_checkbox->addControlSection("fluentform_radio_checkbox_smart_ui",
            __('Checkbox/Radio Smart UI', 'fluentform'), "assets/icon.png", $this);
        $smart_ui->addOptionControl(
            array(
                "type"    => "radio",
                "name"    => __('Enable Smart UI','fluentform'),
                "slug"    => "rc_smart_ui",
                "value"   => ["yes" => __("Yes"), "no" => __("No")],
                "default" => "no",
                "css"     => false
            )
        )->rebuildElementOnChange();

        $smart_ui->addStyleControl(
            array(
                'selector'     => $selector_after,
                'name'         => __("Width"),
                "property"     => "width|height",
                "control_type" => 'slider-measurebox',
                "unit"         => 'px',
                "condition"    => "rc_smart_ui=yes"
            )
        );
        $smart_ui->addStyleControl(
            array(
                'selector'     => $selector,
                'name'         => __("Text Indent"),
                "property"     => "margin-right",
                "control_type" => 'slider-measurebox',
                "unit"         => 'px',
                "condition"    => "rc_smart_ui=yes"
            )
        );
        $smart_ui->addStyleControls(
            array(
                array(
                    "selector"  => $selector_after,
                    "property"  => 'background-color',
                    "slug"      => "cr_bg_color",
                    "condition" => "rc_smart_ui=yes"
                ),
                array(
                    "selector"  => $selector_after,
                    "property"  => 'border-color',
                    "slug"      => "cr_brd_color",
                    "condition" => "rc_smart_ui=yes",
                    "value"     => '#333',
                ),
                array(
                    "selector"  => $selector_after . ", .ff-el-group input[type=checkbox]:checked:after, .ff-el-group input[type=radio]:checked:after",
                    "property"  => 'border-width',
                    "condition" => "rc_smart_ui=yes"
                ),
                array(
                    'name'      => __('Border Radius for Checkbox', 'fluentform'),
                    "selector"  => ".ff-el-group input[type=checkbox]:after, .ff-el-group input[type=checkbox]:checked:after",
                    "property"  => 'border-radius',
                    "condition" => "rc_smart_ui=yes"
                ),
            )
        );

        $smart_ui->addStyleControls(
            array(
                array(
                    "name"         => __('Background Color - Selected State','fluentform'),
                    "selector"     => '.ff-el-group input[type=checkbox]:checked:after, .ff-el-group input[type=radio]:checked:after',
                    "property"     => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition"    => "rc_smart_ui=yes"
                ),
                array(
                    "name"         => __('Border Size - Selected State','fluentform'),
                    "selector"     => '.ff-el-group input[type=checkbox]:checked:after, .ff-el-group input[type=radio]:checked:after',
                    "property"     => 'border-width',
                    "control_type" => 'slider-measurebox',
                    "unit"         => 'px',
                    "condition"    => "rc_smart_ui=yes"
                ),
                array(
                    "name"         => __('Border Color - Selected State','fluentform'),
                    "selector"     => '.ff-el-group input[type=checkbox]:checked:after, .ff-el-group input[type=radio]:checked:after',
                    "property"     => 'border-color',
                    "slug"         => "crc_bg_color",
                    "control_type" => 'colorpicker',
                    "condition"    => "rc_smart_ui=yes"
                )
            )
        );

        $input_section_radio_checkbox_space = $input_section_radio_checkbox->addControlSection("fluentform_radio_checkbox_sp",
            __('Spacing', 'fluentform'), "assets/icon.png", $this);

        $input_section_radio_checkbox_space->addPreset(
            "margin",
            'fluentform_radio_checkbox_margin',
            __("Checkbox/Radio Margin"),
            '.fluentform input[type=checkbox], .ff-el-group input[type=radio]'
        )->whiteList();

        $input_section_radio_checkbox_space->addPreset(
            "padding",
            'fluentform_radio_checkbox_padding',
            __("Label Spacing"),
            '.ff-el-form-check-label, .ff_t_c'
        )->whiteList();
    }

    public function fileUploadStyle()
    {
        $section_file_upload = $this->addControlSection("fluentform_file_upload", __('File Upload Field', 'fluentform'),
            "assets/icon.png", $this);
        $selector = '.ff_upload_btn';

        $section_file_upload->typographySection(__('Button Typography','fluentform'), $selector, $this);
        $section_file_upload->borderSection(__('Button Border','fluentform'), $selector, $this);
        $section_file_upload->boxShadowSection(__('Button Box Shadow','fluentform'), $selector, $this);
        $section_file_upload->boxShadowSection(__('Button Hover Box Shadow','fluentform'), $selector . ":hover", $this);
        $section_file_upload->borderSection(__('Button Hover Border','fluentform'), $selector . ":hover", $this);


        $button = $section_file_upload->addControlSection("fluentform_file_upload_bttn",
            __('Button Style', 'fluentform'),
            "assets/icon.png", $this);
        $button->addPreset(
            "padding",
            "fluentform_file_upload_bttn_padding",
            __('Padding','fluentform'),
            $selector
        )->whiteList();

        $button->addStyleControls(
            array(
                array(
                    "name"     => __('Text Hover Color', 'fluentform'),
                    "selector" => $selector . ':hover',
                    "property" => 'color',
                ),
                array(
                    "selector" => $selector,
                    "property" => 'background-color'
                ),
                array(
                    "name"         => __('Background Hover Color', 'fluentform'),
                    "selector"     => $selector . ':Hover',
                    "property"     => 'background-color',
                    "control_type" => 'colorpicker'
                ),
                array(
                    "name"     => __('Width','fluentform'),
                    "selector" => $selector,
                    "property" => 'width'
                )
            )
        );
    }

    public function progressBarStyle()
    {
        $section_progressbar = $this->addControlSection("fluentform_progress_bar", __("Progress Bar", 'fluentform'),
            "assets/icon.png", $this);

        $section_progressbar->typographySection(__('Typography','fluentform'), '.ff-el-progress-status', $this);
        $section_progressbar->addStyleControls(
            array(
                array(
                    "name"     => __('Text Color', 'fluentform'),
                    "selector" => '.ff-el-progress-status',
                    "property" => 'color'
                )
            )
        );
        $section_progressbar->addStyleControls(
            array(
                array(
                    "name"     => __('Bar Color', 'fluentform'),
                    "selector" => '.ff-el-progress-bar',
                    "property" => 'background-color'
                )
            )
        );
        $section_progressbar->addPreset(
            "padding",
            'fluentform_progress_bar_padding',
            __('Label Spacing','fluentform'),
            '.ff-el-progress-status'
        )->whiteList();
    }

    public function submitBtnStyle()
    {
        $section_submit_btn = $this->addControlSection("fluentform_submit_bttn", __('Submit Button', 'fluentform'),
            "assets/icon.png", $this);

        $selector_submit_bttn = '.ff-btn-submit';
        $section_submit_btn->addStyleControls(
            array(
                array(
                    "name"     => __('Color', "fluentform"),
                    "selector" => $selector_submit_bttn,
                    "property" => 'color'
                ),
                array(
                    "name"     => __('Background Color', "fluentform"),
                    "selector" => $selector_submit_bttn,
                    "property" => 'background-color'
                ),
                array(
                    "name"     => __('Hover Color', "fluentform"),
                    "selector" => '.ff-btn-submit:hover',
                    "property" => 'background-color'
                ),
                array(
                    "name"         => __('Width', "fluentform"),
                    "selector"     => $selector_submit_bttn,
                    "property"     => 'width',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                ),
                array(
                    "name"         => __('Margin Top', 'fluentform'),
                    "selector"     => $selector_submit_bttn,
                    "property"     => 'margin-top',
                    "control_type" => 'slider-measurebox',
                    'unit'         => 'px'
                ),
            )
        );

        $section_submit_btn->addPreset(
            "padding",
            "fluentform_submit_bttn_padding",
            __("Padding", 'fluentform'),
            $selector_submit_bttn
        )->whiteList();

        $section_submit_btn->addPreset(
            "margin",
            "fluentform_submit_bttn_margin",
            __("Margin", 'fluentform'),
            $selector_submit_bttn
        )->whiteList();


        $section_submit_btn->typographySection(__("Typography",'fluentform'), $selector_submit_bttn, $this);
        $section_submit_btn->borderSection(__("Border",'fluentform'), $selector_submit_bttn, $this);
        $section_submit_btn->borderSection(__("Hover Border",'fluentform'), $selector_submit_bttn . ':hover', $this);
        $section_submit_btn->boxShadowSection(__("Box Shadow",'fluentform'), $selector_submit_bttn, $this);
        $section_submit_btn->boxShadowSection(__('Hover Box Shadow','fluentform'), $selector_submit_bttn . ':hover', $this);
    }

    public function stepButtonStyle()
    {
        $section_step_button = $this->addControlSection("section_step_button", __("Step Button", 'fluentform'),
            "assets/icon.png", $this);

        $section_step_button->addPreset(
            "padding",
            "section_step_button_padding",
            __('Padding','fluentform'),
            '.step-nav button'
        )->whiteList();

        $section_step_button->addStyleControl(
            array(
                "name"     => __('Width'),
                "selector" => '.step-nav .ff-btn',
                "property" => 'width'
            )
        );
        $section_step_button_color = $section_step_button->addControlSection("ffsfnb_clr", __('Color', 'fluentform'),
            "assets/icon.png",
            $this);
        $section_step_button_color->addStyleControls(
            array(
                array(
                    "name"     => __('Text Color','fluentform'),
                    "selector" => '.step-nav .ff-btn',
                    "property" => 'color',
                ),
                array(
                    "name"     => __('Text Hover Color','fluentform'),
                    "selector" => '.step-nav .ff-btn:hover',
                    "property" => 'color',
                ),
                array(
                    "name"         => __('Background Color','fluentform'),
                    "selector"     => '.step-nav .ff-btn',
                    "property"     => 'background-color',
                    "control_type" => 'colorpicker'
                ),
                array(
                    "name"         => __('Background Hover Color','fluentform'),
                    "selector"     => '.step-nav .ff-btn:hover',
                    "property"     => 'background-color',
                    "control_type" => 'colorpicker'
                )
            )
        );

        $section_step_button->typographySection(__('Typography','fluentform'), '.step-nav .ff-btn', $this);
        $section_step_button->borderSection(__('Border','fluentform'), '.step-nav .ff-btn', $this);
        $section_step_button->borderSection(__('Hover Border','fluentform'), '.step-nav .ff-btn:hover', $this);
        $section_step_button->boxShadowSection(__('Box Shadow','fluentform'), '.step-nav .ff-btn', $this);
        $section_step_button->boxShadowSection(__('Hover Box Shadow','fluentform'), '.step-nav .ff-btn:hover', $this);
    }

    public function successMessageStyle()
    {
        $section_success_message = $this->addControlSection("fluentform_success_message",
            __('Success Message', 'fluentform'), "assets/icon.png", $this);

        $section_success_message->addStyleControl(
            array(
                'selector' => '.ff-message-success',
                'value'    => 100,
                'property' => 'width'
            )
        )->setUnits("%", "px,%");

        $section_success_message->addStyleControl(
            array(
                'selector' => '.ff-message-success',
                'property' => 'background-color'
            )
        );

        $section_success_message->typographySection(__('Typography','fluentform'), '.ff-message-success, .ff-message-success p',
            $this);
        $section_success_message->borderSection(__('Border','fluentform'), '.ff-message-success', $this);
        $section_success_message->boxShadowSection(__('Box Shadow','fluentform'), '.ff-message-success', $this);

        $section_success_message->addPreset(
            "padding",
            "fluentform_success_message_padding",
            __('Padding','fluentform'),
            '.ff-message-success'
        )->whiteList();
    }

    public function errorMessageStyle()
    {
        $section_error_message = $this->addControlSection("fluentform_error_message",
            __('Validation Error', 'fluentform'), "assets/icon.png", $this);
        $section_error_message->addStyleControls(
            array(
                array(
                    "name"     => __('Text Color','fluentform'),
                    "selector" => '.ff-el-is-error .text-danger',
                    "property" => 'color',
                    "value"    => "#f56c6c"
                ),
                array(
                    "selector" => '.ff-el-is-error .text-danger',
                    "property" => 'font-size',
                    "value"    => 14
                ),
                array(
                    "selector" => '.ff-el-is-error .text-danger',
                    "property" => 'font-weight'
                ),
                array(
                    "selector" => '.ff-el-is-error .text-danger',
                    "property" => 'margin-top',
                    "value"    => 4
                ),
            )
        );
    }
}

new OxyFluentFormWidget();