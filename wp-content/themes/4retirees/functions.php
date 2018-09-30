<?php
//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//  
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );

    wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js' );
    wp_enqueue_script( 'theme', get_stylesheet_directory_uri() . '/assets/js/theme.js' );

    $data = cc_data();

    wp_localize_script( 'theme', 'theme_vars', array(
        'ajax_url'        => admin_url('admin-ajax.php'),
        'questions'       => $data,
        'questions_total' => count($data)
    ) );
}

function theme_init() {

    $labels = array(
        'name'                  => _x( 'Checks', 'Post Type General Name', '4retirees' ),
        'singular_name'         => _x( 'Check', 'Post Type Singular Name', '4retirees' ),
        'menu_name'             => __( 'Checks', '4retirees' ),
        'name_admin_bar'        => __( 'Check', '4retirees' ),
        'archives'              => __( 'Check Archives', '4retirees' ),
        'attributes'            => __( 'Check Attributes', '4retirees' ),
        'parent_item_colon'     => __( 'Parent Check:', '4retirees' ),
        'all_items'             => __( 'All Checks', '4retirees' ),
        'add_new_item'          => __( 'Add New Check', '4retirees' ),
        'add_new'               => __( 'Add New', '4retirees' ),
        'new_item'              => __( 'New Check', '4retirees' ),
        'edit_item'             => __( 'Edit Check', '4retirees' ),
        'update_item'           => __( 'Update Check', '4retirees' ),
        'view_item'             => __( 'View Check', '4retirees' ),
        'view_items'            => __( 'View Checks', '4retirees' ),
        'search_items'          => __( 'Search Checks', '4retirees' ),
        'not_found'             => __( 'Not found', '4retirees' ),
        'not_found_in_trash'    => __( 'Not found in Trash', '4retirees' ),
        'featured_image'        => __( 'Featured Image', '4retirees' ),
        'set_featured_image'    => __( 'Set featured image', '4retirees' ),
        'remove_featured_image' => __( 'Remove featured image', '4retirees' ),
        'use_featured_image'    => __( 'Use as featured image', '4retirees' ),
        'insert_into_item'      => __( 'Insert into item', '4retirees' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', '4retirees' ),
        'items_list'            => __( 'Checks list', '4retirees' ),
        'items_list_navigation' => __( 'Checks list navigation', '4retirees' ),
        'filter_items_list'     => __( 'Filter items list', '4retirees' ),
    );

    $args = array(
        'label'                 => __( 'Checks', '4retirees' ),
        'description'           => __( 'Compatibility Check', '4retirees' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );

    register_post_type( 'compatibility_check', $args );
}

add_filter( 'init', 'theme_init' );

function cc_get_results() {

    /**
     * WORKFLOW
     *
     * 1. Capture submission data and store in post_type compatibility_check
     * 2. Create user from submission details or if already exists retrieve user
     * 3. Store user ID against the submission data in post_type
     * 4. Use the submission email and store it as hash value against post meta (if provided)
     *    may be useful to query against for multiple submissions.
     *
     * 5. Recommended but not part of the original scope, capture the entire submission
     *    before showing the user the "check-complete" <div> within compatability-check.php
     *    then cookie the user so that IF they complete the form (name, email, etc) they
     *    can be associated to the ghost submission. It is better to capture all submissions
     *    regardless for data aggregation purposes.
     *
     */

    $data      = null;
    $check     = isset($_POST['check']) ? $_POST['check'] : null;
    $questions = isset($_POST['questions']) ? $_POST['questions'] : null;

    if ( isset($_POST['form']) ) {
        parse_str($_POST['form'], $data);
    }

    if ( isset($_POST['check']) ) {
        $check = $_POST['check'];
    }

    if ( isset($_POST['questions']) ) {
        $questions = $_POST['questions'];
    }

    /**
     * FORM SUBMISSION
     */
    if (
        ! isset( $data['cc_get_results_nonce'] )
        || ! wp_verify_nonce( $data['cc_get_results_nonce'], 'cc_get_results_action' )
    ) {

        // redirect to desired location and show UI notice
        // recommendation: serialize and log submission and notify admin
        wp_redirect(home_url());

    } else {

        $field_map = array(
            'form_first_name'       => 'First Name',
            'form_last_name'        => 'Last Name',
            'form_email'            => 'Email',
            'form_age'              => 'Age',
            'form_accept_terms'     => 'Accept Terms and Privacy Policy',
            'form_accept_marketing' => 'Access Marketing',
        );

        $form_body = '';
        $form_data = array();

        foreach ( $field_map as $key => $field ) {
            if ( array_key_exists($key, $data) ) {
                $form_body .= $field;
                $form_body .= "\n";
                $form_body .= $data[$key];
            } else {
                $form_body .= $field;
                $form_body .= "\n";
                $form_body .= 'No value provided.';
            }

            $form_data[] = array(
                'field' => $key,
                'label' => $field,
                'value' => isset($data[$key]) ? $data[$key] : '',
            );

            $form_body .= "\n";
            $form_body .= "\n";
        }

        $form_post = wp_insert_post(array(
            'post_title'   => $data['form_email'] . " - ({$data['form_first_name']} {$data['form_last_name']})",
            'post_content' => $form_body,
            'post_status'  => 'publish',
            'post_type'    => 'compatibility_check'
        ));

        update_post_meta($form_post, '_form_uuid', md5($data['form_email']));
        update_post_meta($form_post, '_form_body', $form_body);
        update_post_meta($form_post, '_form_data', $form_data);
        update_post_meta($form_post, '_form_compat_answers', $check);
        update_post_meta($form_post, '_form_compat_questions', $questions);
        update_post_meta($form_post, '_form_remote_address', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);

        # - create a user if one does not exist for the example supplied
        # e.g. email_exists && wp_insert_user

        // update submission with user_id
        # update_post_meta($form_post, '_form_user_id', $user_id);

        $response = cc_process_results($check);

        if ( $form_post ) {
            wp_send_json_success(array(
                 'data'           => $data,
                 'check'          => $check,
                 'questions'      => $questions,
                 'response_count' => $response['matched_clean_count'],
                 'response_value' => $response['value'],
            ));
        } else {
            wp_send_json_error();
        }

    }
}

add_action( 'wp_ajax_cc_get_results', 'cc_get_results' );
add_action( 'wp_ajax_nopriv_cc_get_results', 'cc_get_results' );

function cc_process_results($check) {

    $data = get_field('compatibility_check', 'option');

    $default_providers = get_field('compatibility_check_providers', 'option');

    $providers = array();

    foreach ( $default_providers as $provider ) {
        $providers[$provider['name']] = $provider;
    }

    $compat_data = array();

    foreach ( $data as $key => $_data ) {

        foreach ( $_data['questions'] as $key => $question ) {

            // skip qualifier
            if ( !empty($question['gender_qualifier']) ) {
                continue;
            }

            $hash = md5( trim($question['question']) );

            $compat_data[$hash] = array(
                'providers' => $question['providers'],
                'value'     => $question['average_value'],
            );
        }
    }

    $gender  = null;
    $value   = 0;
    $results = array();

    foreach ($check as $key => $answer) {
        if ( in_array($answer, array('Male', 'Female')) ) {
            $gender = $answer;
            continue;
        }

        if ( $answer === 'Yes' && array_key_exists($key, $compat_data) ) {
            $results = array_merge((array) $results, $compat_data[$key]['providers']);
            $value  += $compat_data[$key]['value'];
        }
    }

    $results_cleaned = array();

    foreach ( $results as $result ) {
        if ( array_key_exists($result, $providers) ) {

            // if gender is excluded from provider, skip the provider in question
            if ( is_array($providers[$result]['exclusion'] )
                 && in_array(strtolower($gender), $providers[$result]['exclusion'])
            ) {
                continue;
            }

            $results_cleaned[$result] = $providers[$result];
        }
    }

    return array(
        'gender'              => $gender,
        'value'               => $value,
        'matched_dirty'       => $results,
        'matched_dirty_count' => count($results),
        'matched_clean'       => $results_cleaned,
        'matched_clean_count' => count($results_cleaned),

    );
}

if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page();
}

function theme_woocommerce_account_dashboard() {
    get_template_part('templates/account-opportunity-list');
    get_template_part('templates/compatibility-check');
}

add_action( 'woocommerce_account_dashboard', 'theme_woocommerce_account_dashboard' );

###############################################################################
# WOOCOMMERCE
###############################################################################

function theme_account_menu_items( $items ) {
    unset($items['downloads']);
    $items['edit-account'] = 'Account Settings';
    return $items;
}

add_filter( 'woocommerce_account_menu_items', 'theme_account_menu_items' );

###############################################################################
# ACF
###############################################################################
function acf_question_providers_list( $field ) {

    $providers = get_field('compatibility_check_providers', 'option');

    foreach ( $providers as $key => $provider ) {
        $field['choices'][$provider['name']] = $provider['name'];

    }

    return $field;

}

add_filter('acf/load_field/key=field_5ba375769fc65', 'acf_question_providers_list');

###############################################################################
# API
###############################################################################

function cc_data() {
    $data = get_field('compatibility_check', 'option');

    $output = array();

    foreach ( $data as $key => $_data ) {
        foreach ( $_data['questions'] as $key => $question ) {
            $hash = md5( trim($question['question']) );
            $output[] = array(
                'question' => $question['question'],
                'values'   => !empty($question['gender_qualifier'])
                    ? array('left' => 'Male', 'right' => 'Female')
                    : array('left' => 'Yes', 'right' => 'No'),
                'hash'     => $hash
            );
        }
    }

    return $output;
}

###############################################################################
# SHORTCODES
###############################################################################

function year_shortcode() {
    $year = date('Y');
    return $year;
}

add_shortcode('year', 'year_shortcode');
