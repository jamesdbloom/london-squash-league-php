<?php
class Form {
    const selected_string = "selected='selected'";

    public static function checked( $checked, $current = true ) {
        return self::checked_selected_helper( $checked, $current, 'checked' );
    }

    public static function selected( $selected, $current = true ) {
        return self::checked_selected_helper( $selected, $current, 'selected' );
    }

    public static function disabled( $disabled, $current = true ) {
        return self::checked_selected_helper( $disabled, $current, 'disabled' );
    }

    private static function checked_selected_helper( $helper, $current, $type ) {
        if ( (string) $helper === (string) $current )
            $result = " $type='$type'";
        else
            $result = '';

        return $result;
    }

    public static function is_post()
    {
        return ('POST' == $_SERVER['REQUEST_METHOD']);
    }

    public static function escape_and_sanitize_field_value($text)
    {
        return htmlspecialchars($text);
    }
}
?>