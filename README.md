Please setup the project and run the migration

**Task 1**

Import the IEEE OUI CSV data using PHP artisan console command

Please check `app\Console\Commands\ImportOuiCsv.php`

`php artisan import:oui-csv`

This command will import all the CSV data into the database

**Task 2**

Implement a JSON API to lookup the vendor's OUI by MAC address

I have added some random MAC addresses with the second character '2', '6', 'A' or 'E' as mentioned. Please check in `public/oui1.csv file`

1. GET request for single MAC lookup:
   ![2023-10-01_18h45_41](https://github.com/ssnatu/glide/assets/31346079/ad2cbf51-344c-4016-8797-f6ae99411aa6)

Response:

![2023-10-01_18h47_22](https://github.com/ssnatu/glide/assets/31346079/01af016a-8cdd-4350-b8ba-35441c3e8b12)

2. POST request for multiple MAC lookup:
   
   ![2023-10-01_18h49_44](https://github.com/ssnatu/glide/assets/31346079/bbe3731a-4742-4781-9122-917657870224)

Response:

![2023-10-01_18h51_16](https://github.com/ssnatu/glide/assets/31346079/ce9c597a-36e8-4dce-af68-6d6de3ab0868)
