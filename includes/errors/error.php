<?php
class Error
{
    /**
     * Stores the list of errors.
     */
    var $errors = array();

    /**
     * Stores the list of data for error codes.
     */
    var $error_data = array();

    var $has_errors = false;

    /**
     * Constructor - Sets up error message.
     */
    public function __construct($code = '', $message = '', $data = '')
    {
        if (empty($code)) {
            return;
        } else {
            $this->add($code, $message, $data);
        }
    }

    /**
     * Retrieve all error codes.
     */
    public function get_error_codes()
    {
        if (empty($this->errors))
            return array();

        return array_keys($this->errors);
    }

    /**
     * Retrieve first error code available.
     */
    public function get_error_code()
    {
        $codes = $this->get_error_codes();

        if (empty($codes))
            return '';

        return $codes[0];
    }

    /**
     * Retrieve all error messages or error messages matching code.
     */
    public function get_error_messages($code = '')
    {
        // Return all messages if no code specified.
        if (empty($code)) {
            $all_messages = array();
            foreach ((array)$this->errors as $code => $messages)
                $all_messages = array_merge($all_messages, $messages);

            return $all_messages;
        }

        if (isset($this->errors[$code]))
            return $this->errors[$code];
        else
            return array();
    }

    /**
     * Get single error message.
     */
    public function get_error_message($code = '')
    {
        if (empty($code))
            $code = $this->get_error_code();
        $messages = $this->get_error_messages($code);
        if (empty($messages))
            return '';
        return $messages[0];
    }

    /**
     * Retrieve error data for error code.
     */
    public function get_error_data($code = '')
    {
        if (empty($code))
            $code = $this->get_error_code();

        if (isset($this->error_data[$code]))
            return $this->error_data[$code];
        return null;
    }

    /**
     * Append more error messages to list of error messages.
     */
    public function add($code, $message, $data = '')
    {
        $this->errors[$code][] = $message;
        if (!empty($data))
            $this->error_data[$code] = $data;
        $this->has_errors = true;
    }

    /**
     * Add data for error code.
     */
    public function add_data($data, $code = '')
    {
        if (empty($code))
            $code = $this->get_error_code();
        $this->error_data[$code] = $data;
        $this->has_errors = true;
    }

    public function has_errors()
    {
        if ($this->has_errors) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString()
    {
        $output = '';
        foreach (array_keys($this->errors) as $code) {
            foreach ($this->errors[$code] as $error_message) {
                $output .= $error_message . ' <br/> ';
            }
            if (!empty($this->error_data[$code])) {
                $output .= $this->error_data[$code] . ' <br/> ';
            }
        }
        return $output;
    }

    public static function is_error($thing)
    {
        if (is_object($thing) && is_a($thing, 'Error'))
            return true;
        return false;
    }

    public static function print_errors(Error $errors)
    {
        if ($errors->get_error_code()) {
            $errors_messages = '';
            $errors_warnings = '';
            foreach ($errors->get_error_codes() as $code) {
                $severity = $errors->get_error_data($code);
                foreach ($errors->get_error_messages($code) as $error) {
                    if ('message' == $severity) {
                        $errors_messages .= '	' . $error . '<br/>';
                    } else {
                        $errors_warnings .= '	' . $error . '<br/>';
                    }
                }
            }
            if (!empty($errors_messages)) {
                print '<div class="errors_messages">' . $errors_messages . '</div>';
            }
            if (!empty($errors_warnings)) {
                print '<div class="errors_warnings">' . $errors_warnings . '</div>';
            }
        }
    }


}
