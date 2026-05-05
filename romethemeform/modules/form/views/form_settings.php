<?php
$captchaVersion = get_option('rform_recaptcha_version', 'v2');

$siteKeyV2 = get_option('rform_recaptcha_site_key_v2', '');
$secretKeyV2 = get_option('rform_recaptcha_secret_key_v2', '');

$siteKeyV3 = get_option('rform_recaptcha_site_key_v3', '');
$secretKeyV3 = get_option('rform_recaptcha_secret_key_v3', '');

?>

<div class="px-4 mb-5 scroll-behavior-smooth scrollspy" data-scrollspy="#widget-category" data-rootMargin="-30% 0px -70% 0px" tabindex="0">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <h1>Form Settings</h1>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    License :
                    <span class="license-status">
                        <?php
                        if (class_exists('RTMKitPro\Core\Plugin') && \RTMKitPro\Modules\Licenses\LicenseStorage::instance()->isLicenseActive()) {
                            echo \RTMKitPro\Modules\Licenses\LicenseStorage::instance()->get_product_name();
                        } else {
                            echo 'Free';
                        }
                        ?>
                    </span>
                </div><?php if (!class_exists('RTMKitPro\Core\Plugin') || !\RTMKitPro\Modules\Licenses\LicenseStorage::instance()->isLicenseActive()) : ?>
                    <p class="m-0">Upgrade premium to unlock all features <a href="https://rometheme.net/plugins/rtmkit/pricing/" target="_blank">Upgrade Now</a></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="divider"></div>
        <div class="scrollspy-content gap-3" style="margin-bottom: 9rem;">
            <div class="card rounded-4  flex-column gap-3" id="recaptcha-settings">
                <div class="pb-3 pt-1 border-bottom d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <h4 class="m-0">reCAPTCHA</h4>
                    </div>
                    <span>
                        reCAPTCHA is a free service that protects your website from spam and abuse. It uses advanced risk analysis techniques to tell humans and bots apart.
                    </span>
                </div>
                <div class="row row-cols-2 g-3">
                    <div class="col-2">
                        <div>
                            <label for="captcha-version" class="form-label">reCaptcha Version</label>
                            <select name="captcha-version" id="captcha-version" class="form-control rounded-3">
                                <option value="v2" <?php selected($captchaVersion, 'v2'); ?>>reCAPTCHA v2</option>
                                <option value="v3" <?php selected($captchaVersion, 'v3'); ?>>reCAPTCHA v3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="d-flex gap-3">
                            <div class="w-100">
                                <label for="captcha-site-key" class="form-label">Site Key</label>
                                <input type="text" name="captcha-site-key" id="captcha-site-key-v2" class="form-control rounded-3" value="<?php echo esc_attr($siteKeyV2); ?>" style="<?php echo ($captchaVersion === 'v2') ? '' : 'display:none;'; ?>">
                                <input type="text" name="captcha-site-key" id="captcha-site-key-v3" class="form-control rounded-3" value="<?php echo esc_attr($siteKeyV3); ?>" style="<?php echo ($captchaVersion === 'v3') ? '' : 'display:none;'; ?>">
                            </div>
                            <div class="w-100">
                                <label for="captcha-secret-key" class="form-label">Secret Key</label>
                                <input type="text" name="captcha-secret-key" id="captcha-secret-key-v2" class="form-control rounded-3" value="<?php echo esc_attr($secretKeyV2); ?>" style="<?php echo ($captchaVersion === 'v2') ? '' : 'display:none;'; ?>">
                                <input type="text" name="captcha-secret-key" id="captcha-secret-key-v3" class="form-control rounded-3" value="<?php echo esc_attr($secretKeyV3); ?>" style="<?php echo ($captchaVersion === 'v3') ? '' : 'display:none;'; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <span>
                    Configure your Google reCAPTCHA keys via the admin panel.
                    Don't have one yet?
                    <a href="https://www.google.com/recaptcha/admin" target="_blank">Create from here.</a>
                </span>
                <div class="d-flex gap-3">
                    <button class="btn btn-secondary rounded-3 text-nowrap gap-2 save-recaptcha" id="save-recaptcha">
                        <svg class="icon-loading" width="20" height="20" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1696_11964)">
                                <path d="M18.6321 1.20117V6.11315L13.4512 6.1131" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M3.68262 22.7988V17.8869H8.86359" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20.4634 9.6886C20.6631 10.4482 20.7693 11.2445 20.7693 12.0649C20.7693 17.3308 16.3954 21.5997 10.9999 21.5997C8.08203 21.5997 5.46292 20.3511 3.67285 18.3716" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1.51966 14.3769C1.33076 13.6367 1.23047 12.8622 1.23047 12.0649C1.23047 6.79905 5.60433 2.53021 10.9998 2.53021C14.0768 2.53021 16.8217 3.91869 18.6124 6.08869" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1696_11964">
                                    <rect width="22" height="24" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <i class="fa-solid fa-check icon-btn"></i>
                        <span class="text-white">Save Changes</span></button>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .btn.save-recaptcha {
        padding: 16px 32px;
    }

    .btn.save-recaptcha .icon-loading {
        display: none;
    }

    .btn.save-recaptcha.loading .icon-loading {
        display: inline-block;
        animation: rotate 1s linear infinite;
    }

    .btn.save-recaptcha.loading .icon-btn {
        display: none;
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>