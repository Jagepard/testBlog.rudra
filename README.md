[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jagepard/Rudra-Framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jagepard/Rudra-Framework/?branch=master)
[![Code Climate](https://codeclimate.com/github/Jagepard/Rudra-Framework/badges/gpa.svg)](https://codeclimate.com/github/Jagepard/Rudra-Framework)
[![CodeFactor](https://www.codefactor.io/repository/github/jagepard/rudra-framework/badge)](https://www.codefactor.io/repository/github/jagepard/rudra-framework)
![GitHub](https://img.shields.io/github/license/jagepard/Rudra-Framework.svg)
-----

# testBlog_rudra

```
git clone git@github.com:Jagepard/testBlog.rudra.git
```
```
composer install
```

Create a database, for example: ```testBlog_rudra```
Specify connection parameters in the configuration file: ```config/setting.local.yml```
```yml
database:
    dsn: mysql:dbname=testBlog_rudra;host=127.0.0.1
```

Run migrations:
```
php rudra migrate
```
```
Enter container (empty for Ship):
The App\Ship\Migration\Users_21012021130204_migration has migrate
```
```
Enter container (empty for Ship): blog
The App\Containers\Blog\Migration\Materials_26012024191954_migration has migrate
```
Seeding user data:
```
php rudra seed
```
```
Enter container (empty for Ship):
The App\Ship\Seed\Users_21012021144905_seed was seed
```
Launch the built-in server:
```
php rudra run
```
or
```
php rudra serve
```