<div dir="rtl">

# 📦 نظام إدارة الطلبات – Order Management System

## 📝 وصف المشروع
نظام إدارة الطلبات هو تطبيق ويب بسيط تم تطويره باستخدام **PHP بدون Laravel**، يهدف إلى إدارة طلبات العملاء والمنتجات المرتبطة بها. يعتمد المشروع على مفاهيم **البرمجة الكائنية (OOP)** و**أنماط التصميم (Design Patterns)** لضمان تنظيم الكود وسهولة الصيانة.

---------------------------------
🖥️ Project Interface (English)
The interface is clean and straightforward, designed to display and manage customer orders directly from the browser. When visiting index.php, users see a list of all registered orders with key details such as:

Order number

Customer name

Total price (including VAT and shipping)

Order status

Each order includes its associated products, showing quantity and price per item. The system is built to be easily extendable, with future enhancements like:

A form to create new orders

A dedicated page for viewing order details

Full CRUD support via RESTful APIs

This structure reflects a strong separation of concerns, using OOP and design patterns to keep logic modular and maintainable.
---------------------------------

## 🧱 هيكل المجلدات

project/
├── config/              ← إعدادات الاتصال بقاعدة البيانات
├── core/                ← الأصناف الأساسية مثل BaseModel و Settings
├── models/              ← النماذج المرتبطة بالجداول (Product, Order, OrderItem)
├── entities/            ← الأصناف الكائنية للمنتجات (Product, DigitalProduct, PhysicalProduct)
├── repositories/        ← الوصول إلى البيانات باستخدام Repository Pattern
├── services/            ← منطق الأعمال باستخدام Service Pattern
├── observers/           ← تسجيل الأحداث باستخدام Observer Pattern
├── facades/             ← واجهة مبسطة باستخدام Facade Pattern
├── public/              ← نقطة التشغيل الرئيسية (index.php)
└── api/                 ← واجهات RESTful API للطلبات والمنتجات

-------------------------------------------------------------
#### 🗃️ قاعدة البيانات (MySQL)
# الجداول:
``` sql
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  description TEXT,
  price DECIMAL(10,2),
  type ENUM('digital', 'physical')
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(255),
  status VARCHAR(50),
  total_price DECIMAL(10,2),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_name VARCHAR(255),
  quantity INT,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE order_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  message TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

///    كتابتهم في الsql ضمن القاعدة 
 
🎯 أنماط التصميم المستخدمة
   الوصف                               النمط  
Repository	     OrderRepository لتنفيذ عمليات CRUD على جدول الطلبات
Service     	OrderService لتنفيذ منطق إنشاء الطلب وحساب السعر
Observer    	OrderObserver لتسجيل حدث إنشاء الطلب في order_logs
Facade	         OrderFacade لتبسيط استدعاء الخدمات من نقطة واحدة
Singleton	      Settings لتخزين إعدادات النظام مثل VAT وتكلفة الشحن

/////////////////////////

<div dir="rtl">

## 🖥️ واجهة المشروع

واجهة المشروع بسيطة وواضحة، مصممة لتجربة الطلبات وعرضها بشكل مباشر. عند فتح `index.php` في المتصفح، تظهر قائمة الطلبات المسجلة، مع تفاصيل مثل:

- رقم الطلب
- اسم العميل
- السعر الإجمالي (يشمل الضريبة وتكلفة الشحن)
- حالة الطلب

كل طلب يحتوي على المنتجات المرتبطة به، مع الكمية والسعر لكل منتج.

تم تصميم الواجهة لتكون قابلة للتوسعة لاحقًا، مثل:

- إضافة نموذج إدخال طلب جديد
- عرض تفاصيل كل طلب في صفحة مستقلة
- دعم التعديل والحذف من خلال واجهات API

</div>

/////////////////////////

🚀 خطوات التشغيل
تأكد من تشغيل MySQL و Apache في XAMPP.
#1
أنشئ قاعدة بيانات باسم order_db في phpMyAdmin 
#2
نفّذ جداول SQL المذكورة أعلاه.
#3
ضعي المشروع داخل htdocs وشغّل
http://localhost/order-management/public/index.php

#4
استخدم Postman لاختبار واجهات API

///////////////////////////////////////////////////

✅ ملاحظات إضافية
تم استخدام PDO للاتصال الآمن بقاعدة البيانات

تم فصل منطق البيانات عن منطق الأعمال لتسهيل الصيانة

يمكن توسيع المشروع لاحقًا بإضافة واجهة HTML أو دعم تسجيل الدخول



##$ made with lo♥e ☺ Aya Barghouth
