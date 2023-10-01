Please setup the project and run the migration

**Task 1**

Import the IEEE OUI CSV data using PHP artisan console command

Please check `app\Console\Commands\ImportOuiCsv.php` for functionality

Artisan command to import CSV

`php artisan import:oui-csv`

This command will import all the CSV data into the database

**Task 2**

Implement a JSON API to lookup the vendor's OUI by MAC address

You can find the code in `app\Http\Controllers\OuiController.php`

There is a validation to validate the MAC address and the code can be found in `app\Http\Requests\MacAddressRequest.php` for 'GET' and `app\Http\Requests\MacAddressMultipleRequest.php` for 'POST'

There are two models `Organization` and `Assignment`

1. GET request for single MAC lookup:
   
![2023-10-01_19h41_41](https://github.com/ssnatu/glide/assets/31346079/c21e9fad-f175-4600-a557-954ef843fcd0)

Response:

![image](https://github.com/ssnatu/glide/assets/31346079/76e2143e-68e7-4c2b-88aa-f40214dc2a9a)


2. POST request for multiple MAC lookup:
   
   ![2023-10-01_18h49_44](https://github.com/ssnatu/glide/assets/31346079/bbe3731a-4742-4781-9122-917657870224)

Response:

![2023-10-01_18h51_16](https://github.com/ssnatu/glide/assets/31346079/ce9c597a-36e8-4dce-af68-6d6de3ab0868)

I have added some random MAC addresses with the second character '2', '6', 'A' or 'E' as mentioned and you can see it in the above POST request. Please check in `public/oui1.csv file`
