<?php

class RFormControls extends \Elementor\Base_Data_Control
{

    public function get_type()
    {
        return 'rform_control';
    }

    protected function get_default_settings()
    {
        return ['form_id' => ""];
    }

    public function enqueue()
    {
        $form_nonce = wp_create_nonce('rform_form_ajax_nonce');
        // Styles
        wp_register_style('control-style', \RomethemeForm::controls_url() . 'assets/css/form_modal.css');
        wp_enqueue_style('control-style');

        // Scripts
        wp_register_script('control-script', \RomeThemeForm::controls_url() . 'assets/js/form_modal.js');
        wp_enqueue_script('control-script');
        wp_register_script('rformcontrol-script', \RomeThemeForm::controls_url() . 'assets/js/form_picker.js');
        wp_enqueue_script('rformcontrol-script');
        wp_localize_script('control-script', 'adminData', array(
            'adminUrl' => esc_url(admin_url()),
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $form_nonce
        ));
    }

    public function content_template()
    {
        $control_uid = $this->get_control_uid();

        $list = [];

        $template =  get_posts(['post_type' => 'romethemeform_form', 'posts_per_page' => -1]);
        $list = [];
        foreach ($template as $form) {
            $list[$form->ID]  = $form->post_title;
        }
?>
        <div class="elementor-control rform-editform flex-direction-col" id="<?php echo esc_attr($control_uid); ?>" data-setting="{{ data.name }}">
            <div class="elementor-control-input-wrapper">
                <span>You can create or select the form.</span>
                <div class="rform-editform-wrapper edit-form-wrapper">
                    <button data-control-uid="<?php echo esc_attr($control_uid) ?>" type="button" class="rform-editform-btn elementor-button e-primary elementor-modal-iframe-btn-control">
                        <?php echo esc_html__('EDIT FORM', 'romethemeform') ?>
                    </button>
                </div>
            </div>
            <div class="rform-editform-modal">
                <# var form_id=data.form_id; #>
                    <div class="rform-modal-content">
                        <div class="rform-modal-header">
                            <div class="rform-logo">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="esTFm6Uueg21" width="30" height="30" viewBox="0 0 492.94 492.94" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" project-id="f39061fa0d7140c0b843c54bc4fc263e" export-id="8175fbc5b63142aeb21ae9d901b96505" cached="false" fill="#00cea6">
                                    <g transform="matrix(1.449639 0 0 1.449639-132.842546-145.601744)">
                                        <rect width="82.32" height="82.32" rx="0" ry="0" transform="translate(123.22 294.99)" fill="currenColor" stroke-width="0" />
                                        <g>
                                            <polygon points="342.61,268.16 316.74,293.64 261.59,238.49 287.45,212.63 342.61,268.16" opacity="0.6" fill="currenColor" stroke-width="0" />
                                            <polygon points="400.1,377.31 288.12,377.31 270.64,359.83 260.83,350.02 205.69,294.88 123.22,212.41 123.22,100.44 123.43,100.65 400.06,377.27 400.1,377.31" fill="currenColor" stroke-width="0" />
                                        </g>
                                        <path d="M395.54,206.04c2.63,2.62,2.61,6.89-.03,9.49l-18.16,17.89-.21.21-34.52,34.53-11.88,11.33l3.92-3.74c4.36-4.16,4.45-11.1.18-15.37L197.92,123.48h114.16c.53,0,1.04.21,1.41.58l82.04,81.98h.01Z" fill="currenColor" stroke-width="0" />
                                    </g>
                                </svg>
                                <strong>RTMForm</strong>
                            </div>
                            <div>
                                <button class="rform-close-btn"><i class="eicon eicon-close"></i></button>
                            </div>
                        </div>
                        <div class="rform-modal-tabs">
                            <div class="rform-modal-tab">
                                <label class="rform-radiobtn-container"> Select Form
                                    <input type="radio" class="rform-radio-btn" data-content="#tab-content-select" checked id="tab-select" name="radio-btn">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="rform-radiobtn-container"> New Form
                                    <input type="radio" class="rform-radio-btn" id="tab-new" data-content="#tab-content-new" name="radio-btn">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="rform-modal-tab-content">
                                <div class="rform-tab-content" id="tab-content-select">
                                    <div class="rform-tab-select">
                                        <# if ( data.label ) {#>
			                        <label for="<?php echo esc_attr($control_uid); ?>" class="form-label">{{{ data.label }}}</label>
			                    <# } #>
                                    <select class="rform-select-form">
					                <?php foreach ($list as $key => $value) : ?>
					                    <option value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value) ?></option>
					                <?php endforeach; ?>
				                    </select>
                                   </div>
                                   <div class="rform-tab-select-footer">
                                        <button class="rform-modal-btn rform-select-edit">Edit Content</button>
                                        <button class="rform-modal-btn rform-select-savebtn">Save & Close</button>
                                   </div>
                                </div>
                                <div class="rform-tab-content" id="tab-content-new">
                                    <form id="rform-newform">
                                    <input id="action" name="action" type="text" value="rtformnewform" hidden>
                                        <div class="newform-tabs">
                                            <div class="newform-tab-header">
                                                <div class="tab-item active" data-tab="tab-general">General</div>
                                                <div class="tab-item " data-tab="tab-confirmation">Confirmation</div>
                                                <div class="tab-item " data-tab="tab-notification">Notification</div>
                                            </div>
                                            <div class="newform-tab-content">
                                                <div id="tab-general" class="tab-pane active">
                                                    <label for="new-form-name" class="form-label">Form Name</label>
                                                    <input type="text" class="rform-input-control" name="form-name">
                                                    <h5>Settings</h5>
                                                    <hr class="mb-3">
                                                    <div class="mb-3">
                                                        <label for="success-message" class="form-label">Success Message</label>
                                                         <input type="text" class="rform-input-control" id="success-message" name="success-message" value="Thank you! Form submitted successfully.">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="entry-name" class="form-label">Entry Title</label>
                                                        <input type="text" class="rform-input-control" id="entry-name" name="entry-name" value="Entry #">
                                                        <p class="text"><?php echo esc_html('To set a custom entry title, enclose the input name in {{}}.') ?></p>
                                                    </div>
                                                    <div class="switch-container">
                                                        <span>
                                                            <p class="form-label">Require Login</p>
                                                            <p class="text">Without login, user can't submit the form.</p>
                                                        </span>
                                                        <label class="switch">
                                                            <input name="require-login" id="switch" type="checkbox" value="true">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="tab-confirmation" class="tab-pane">
                                                    <div class="switch-container">
                                                        <span>
                                                            <h5 class="m-0">Confirmation mail to user</h5>
                                                        </span>
                                                        <label class="switch">
                                                            <input name="confirmation" id="switch_confirmation" type="checkbox" value="true">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p class="conf_desc" >Want to send a submission copy to user by email? <strong style="color:white;">Active this one.The form must have at least one Email widget and it should be required.</strong></p>
                                                    <div id="confirmation_form">
                                                        <div class="mb-3">
                                                            <label for="email_subject" class="form-label">Email Subject</label>
                                                            <input type="text" class="rform-input-control" name="email_subject" id="email_subject" placeholder="Enter Email Subject Here">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email_subject" class="form-label">Email From</label>
                                                            <input type="email" class="rform-input-control" name="email_from" id="email_from" placeholder="mail@example.com">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email_subject" class="form-label">Email Reply To</label>
                                                            <input type="text" class="rform-input-control" name="email_replyto" id="email_replyto" placeholder="mail@example.com">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="thks_mssg" class="form-label">Thankyou Message</label>
                                                            <textarea class="rform-input-control" id="thks_msg" name="tks_msg" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tab-notification" class="tab-pane">
                                                    <div class="switch-container">
                                                        <span>
                                                            <h5 class="m-0">Notification mail to Admin</h5>
                                                        </span>
                                                        <label class="switch">
                                                            <input name="notification" id="switch_notification" type="checkbox" value="true">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p class="notif-desc">Want to send a submission copy to admin by email? <strong style="color:white;">Active this one.</strong></p>
                                                    <div id="notification_form">
                                                        <div class="mb-3">
                                                            <label for="notif_subject" class="form-label">Email Subject</label>
                                                            <input type="text" class="rform-input-control" name="notif_subject" id="notif_subject" placeholder="Enter Email Subject Here">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="notif_email_to" class="form-label">Email From</label>
                                                            <input type="email" class="rform-input-control" name="notif_email_from" id="notif_email_from" placeholder="mail@example.com">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="notif_email_to" class="form-label">Email To</label>
                                                            <input type="text" class="rform-input-control" name="notif_email_to" id="notif_email_to" placeholder="mail@example.com">
                                                            <span class="fw-light fst-italic text text-black-50">Enter admin email where you want to send mail. <strong style="color:white">for multiple email addresses please use "," separator.</strong></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="thks_mssg" class="form-label">Admin Note</label>
                                                            <textarea class="rform-input-control" id="adm_msg" name="adm_msg" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="rform-tab-new-footer">
                                        <button class="rform-modal-btn rform-new-savebtn">Save & Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>

            <div id="myModal<?php echo esc_attr($control_uid) ?>" class="modal rform-editor-modal">
                    <div class="modal-content">
                        <div class="elementor-editor-header-iframe">
                            <div class="rform-editor-header">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="esTFm6Uueg21" width="30" height="30" viewBox="0 0 492.94 492.94" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" project-id="f39061fa0d7140c0b843c54bc4fc263e" export-id="8175fbc5b63142aeb21ae9d901b96505" cached="false" fill="#00cea6">
                                    <g transform="matrix(1.449639 0 0 1.449639-132.842546-145.601744)">
                                        <rect width="82.32" height="82.32" rx="0" ry="0" transform="translate(123.22 294.99)" fill="currenColor" stroke-width="0" />
                                        <g>
                                            <polygon points="342.61,268.16 316.74,293.64 261.59,238.49 287.45,212.63 342.61,268.16" opacity="0.6" fill="currenColor" stroke-width="0" />
                                            <polygon points="400.1,377.31 288.12,377.31 270.64,359.83 260.83,350.02 205.69,294.88 123.22,212.41 123.22,100.44 123.43,100.65 400.06,377.27 400.1,377.31" fill="currenColor" stroke-width="0" />
                                        </g>
                                        <path d="M395.54,206.04c2.63,2.62,2.61,6.89-.03,9.49l-18.16,17.89-.21.21-34.52,34.53-11.88,11.33l3.92-3.74c4.36-4.16,4.45-11.1.18-15.37L197.92,123.48h114.16c.53,0,1.04.21,1.41.58l82.04,81.98h.01Z" fill="currenColor" stroke-width="0" />
                                    </g>
                                </svg>
                                <strong>RTMForm</strong>
                            </div>
                            <button id="rform-editform-button" data-control-uid="<?php echo esc_js($control_uid) ?>" class="rform-modal-btn elementor-modal-iframe-btn-control "><?php echo esc_html__('SAVE & CLOSE', 'romethemeform') ?></button>
                        </div>
                        <div class="elementor-editor-container">
                            <iframe class="ifr-editor rform-ifr-editor" id="ifr-<?php echo esc_attr($control_uid) ?>" src="" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>

        </div>
        <?php
    }
}
