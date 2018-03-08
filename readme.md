## 介绍
框架Laravel 5.6

语言 PHP 7.1

前端 HTML, Bootstrap

## 设置
运行如下命令

composer update

php artisan migrate 

php artisan db:seed

配置XAMMP环境 访问路径便可以运行

## 代码文件
/.env 本地环境配置
/app/Models/TheaterSeats.php

/app/Models/UserSeats.php

/app/Http/Controllers/UserSeatsController.php

/database/migrations/create_user_seats_table.php

/database/migrations/create_area_row_table.php

/database/migrations/create_row_seats_table.php

/database/seeds/BuildAreaRowSeeder.php

/database/seeds/BuildRowSeatsSeeder.php

/resources/views/app.blade.php

/resources/views/head.blade.php

/resources/views/index.blade.php

/resources/views/show.blade.php
