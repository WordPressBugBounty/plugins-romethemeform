<?php

$entry_id = sanitize_text_field($_POST['entries_id']);
$datas = json_decode(get_post_meta($entry_id, 'rform-entri-data', true), true);
$entry = get_post($entry_id);
$form_id = get_post_meta($entry_id, 'rform-entri-form-id', true);
$form_name = get_the_title($form_id);
$pageID = get_post_meta($entry_id, 'rform-entri-referal', true);
$pageUrl = get_permalink($pageID);

?>

<div class="d-flex flex-column gap-3 mt-3">
    <div class="d-flex align-items-center gap-3 rounded-2">
        <button class="btn btn-secondary px-4 py-2" id="back-to-submission">
            <i class="fa-solid fa-arrow-left"></i>
            Back</button>
        <h3 class="m-0 text-white"><?php echo esc_html($entry->post_title) ?></h3>
    </div>
    <div class="row row-cols-2 gx-5">
        <div class="col col-lg-7">
            <div class="d-flex flex-column">
                <table class="rtm-table table-list" style="border-spacing: 0px 12px;">
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($datas as $key => $value) :
                            $index++;
                            $label = ucwords(str_replace(['-', '_'], ' ', $key))
                        ?>
                            <tr>
                                <td>
                                    <?php echo sprintf('%02d', $index) ?>
                                </td>
                                <td scope="row"><?php echo esc_html($label) ?></td>
                                <td><?php echo (is_array($value)) ? esc_html(implode(' , ', $value)) : esc_html($value) ?></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col col-lg-5">
            <div class="card rounded-3 p-3 gap-3 p-4">
                <h3 class="m-0 text-white">Submission Information</h3>
                <table class="rtm-table table-flush">
                    <tr>
                        <td>Form Name</td>
                        <td><?php echo esc_html($form_name) ?></td>
                    </tr>
                    <tr>
                        <td>Entry ID</td>
                        <td><?php echo esc_html($entry_id) ?></td>
                    </tr>
                    <tr>
                        <td>Referal Page</td>
                        <td>
                            <a href="<?php echo esc_url($pageUrl) ?>" class="link-accent"><?php echo esc_html(get_the_title($pageID)) ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Entry Date</td>
                        <td>
                            <?php echo esc_html($entry->post_date) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>