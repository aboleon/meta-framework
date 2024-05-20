<?php


use Illuminate\Http\RedirectResponse;
use JetBrains\PhpStorm\Pure;


function aboleon_parse_response($response): string
{
    $html = '';
    if (is_string($response)) {
        return aboleon_info_notice($response);
    }
    if ($response instanceof RedirectResponse) {
        return $html;
    }
    if (!is_array($response)) {
        return $html;
    }

    if (array_key_exists('messages', $response)) {
        foreach ($response['messages'] as $val) {
            foreach ($val as $key => $message) {
                $html .= aboleon_alert_box($message, $key);
            }
        }
        unset($response['messages']);
    }
    unset($response['error']);
    unset($response['abort']);

    if ($response && (auth()->check() && auth()->user()->hasRole('dev'))) {
        ob_start();
        foreach ($response as $key => $val) {
            d($val, $key);
            unset($response[$key]);
        }
        $html .= ob_get_contents();
        ob_end_clean();
    }
    return $html;
}

function aboleon_validation_errors($errors)
{
    if ($errors->any()) {
        foreach ($errors->all() as $error) {
            echo aboleon_critical_notice($error);
        }
    }
}


function aboleon_alert_box($message, $class): string
{
    return '<div class="alert alert-' . $class . '">' . $message . "</div>";
}

#[Pure] function aboleon_critical_notice($message): string
{
    return aboleon_alert_box($message, 'danger');
}

#[Pure] function aboleon_success_notice($message): string
{
    return aboleon_alert_box($message, 'success');
}

#[Pure] function aboleon_warning_notice($message): string
{
    return aboleon_alert_box($message, 'warning');
}

#[Pure] function aboleon_info_notice($message): string
{
    return aboleon_alert_box($message, 'info');
}
