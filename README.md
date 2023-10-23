# langfiles-laravel

Localization of projects created using the Laravel framework

If you want to use the texts provided by the [langfiles](https://langfiles.com/) website in your project that you built using the Laravel framework, you must follow these steps.

1. Create a class name **LF.php** in the **App** folder.
2. **Copy** the following code and **paste** it into the **LF.php** file.
3. Add this line 
    ```php
    'LF' => App\LF::class,
    ```
    in the array in the "**aliases**" key in the **app.php** file located at **config/app.php**.
4. Add the following JavaScript code in the **app.blade.php** file located in **/resources/views/** at the end of the body element.
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
5. Use the following attribute for any element whose text you want to be fetched from [langfiles.com](https://langfiles.com/).
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
