<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PostImage implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $ACCEPTABLE_MIME_TYPES = ['image/webp', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        $pattern = "/data:\w{0,}\/\w{0,};base64/";
        $removeType = preg_replace($pattern, '', $value);
        
        $image = base64_decode($removeType);
        $f = finfo_open();
        $fileType = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);

        foreach ($ACCEPTABLE_MIME_TYPES as $mime_type) {
            if($mime_type === $fileType) {
                return true;
            }
        }
        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Image does not have a valid format';
    }
}
