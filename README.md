# 📚 Library Control Site

Bu proje, **kütüphane yönetim sistemi** işlevi gören bir web uygulamasıdır. Kullanıcılar kitapları görüntüleyebilir, ödünç alabilir ve iade edebilir. Admin paneli ile kitap ve kullanıcı yönetimi yapılabilir.

## 🚀 Özellikler

* 📖 Kitap listesi görüntüleme
* 👤 Kullanıcı kaydı ve girişi
* 📅 Kitap ödünç alma ve iade
* 🔒 Admin girişi
* 🛠️ Kitap ekleme, silme, düzenleme (Admin Panel)

## 🧰 Kullanılan Teknolojiler

* PHP (SQLSRV sürücüsü ile)
* HTML / CSS / JavaScript
* Microsoft SQL Server
* Bootstrap

## 🛠️ Kurulum Adımları

1. Bu repoyu klonlayın:

   ```bash
   git clone https://github.com/Scorpiolupe/librarycontrolsite.git
   ```

2. Proje dosyalarını web sunucunuzun kök dizinine taşıyın:
   Örn: `C:\xampp\htdocs\librarycontrolsite`

3. [Microsoft Drivers for PHP for SQL Server](https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server) eklentisini yükleyin ve `php.ini` dosyanıza şu satırı eklediğinizden emin olun:

   ```
   extension=php_sqlsrv.dll
   ```

4. SQL Server Management Studio ile `library` adında bir veritabanı oluşturun ve ilgili tabloları içeren `.sql` betiğini içe aktarın.

5. `config.php` veya bağlantı dosyasındaki SQLSRV ayarlarını aşağıdaki gibi yapılandırın:

   ```php
   $serverName = "localhost";
   $connectionOptions = array(
       "Database" => "library",
       "Uid" => "kullanici_adiniz",
       "PWD" => "sifreniz"
   );

   $conn = sqlsrv_connect($serverName, $connectionOptions);

   if (!$conn) {
       die(print_r(sqlsrv_errors(), true));
   }
   ```

6. Projeyi tarayıcıda açın:

   ```
   http://localhost/librarycontrolsite
   ```

## 🔐 Varsayılan Giriş Bilgileri

**Admin:**

* Kullanıcı Adı: `admin`
* Şifre: `admin123`

**Kullanıcı:**

* Yeni kullanıcı oluşturabilirsiniz.

