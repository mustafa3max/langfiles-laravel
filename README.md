# langfiles-laravel

Localization of projects created using the Laravel framework

If you want to use the texts provided by the [langfiles](https://langfiles.com/) website in your project that you built using the Laravel framework, you must follow these steps.

1. Create a class name **LF.php** in the **App** folder.
2. **Copy** the following code and **paste** it into the **LF.php** file.
   ```php
   <?php

    namespace App;
    
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Http;
    
    class LF
    {
        static private $keys = [];
        static public $strings = [];
        static $stringsOnline = [];
    
        static function initStrings()
        {
            $api = "https://langfiles.com/api/keys-values";
    
            $response = Http::post($api, [
                "lang" => App::currentLocale(),
                "all_key" => self::$keys
            ]);
    
            self::$stringsOnline = $response->json();
        }
    
        static function init()
        {
            self::initStrings();
            foreach (self::$keys as $key) {
                try {
                    self::$strings[$key] = self::$stringsOnline[$key];
                } catch (\Throwable $th) {
                    self::$strings[$key] = $key;
                }
            }
        }
    
        static function str(String $key)
        {
            self::$keys[] = $key;
    
            try {
                return self::$strings[$key];
            } catch (\Throwable $th) {
                return $key;
            }
        }
    
        static function ready()
        {
            self::init();
    
            return self::$strings;
        }
    }
   ```
4. Add this line 
    ```php
    'LF' => App\LF::class,
    ```
    in the array in the "**aliases**" key in the **app.php** file located at **config/app.php**.
5. Add the following JavaScript code in the **app.blade.php** file located in **/resources/views/** at the end of the body element.
    ```javascript
    <script>
        const strings = @json(LF::ready());
        const elStr = document.querySelectorAll("[lf]");
        var index = 0;
        elStr.forEach(element => {
            element.innerText = strings[element.getAttribute('lf')];
            index++;
        });
    </script>
    ```
6. Use the following attribute for any element whose text you want to be fetched from [langfiles.com](https://langfiles.com/).
   * **attribute:** `lf=""`.
   * **Import text:** `{{ LF::str('auto_cad') }}`.
   * **Example with h1 element:** 
    ```php
     <h1 lf="{{ LF::str('login') }}"></h1>
    ```
   * **When operating:** 
    ``` html
    <h1 lf="login">تسجيل الدخول</h1>
    ```
