<?php

if (!function_exists('passwordGeneration')) {
    /**
     * @param string|null $password
     *
     * @return string
     */
    function passwordGeneration(?string $password = ""): string
    {
        $data = htmlHideCode($password);

        if (is_null($data)) {
            throw new \Exception("Değer Boş Olamaz !!!");
        }

        return '#?!$$££#>@$%^&*-' . $data . '!@#$%^&*()_?+%+';
    }
}


if (!function_exists('htmlHideCode')) {
    /**
     * @param string|null $code
     *
     * @return string|null
     */
    function htmlHideCode(?string $code = ""): ?string
    {
        if (!empty($code) && is_string($code)) {
            $data = trim($code);
            $data = stripslashes($data);

            return htmlspecialchars($data);
        }

        return null;
    }
}
