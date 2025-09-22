<div dir="rtl">

# 📦 نظام إدارة الطلبات – Order Management System

## 📝 وصف المشروع
نظام إدارة الطلبات هو تطبيق ويب بسيط تم تطويره باستخدام **PHP بدون Laravel**، يهدف إلى إدارة طلبات العملاء والمنتجات المرتبطة بها. يعتمد المشروع على مفاهيم **البرمجة الكائنية (OOP)** و**أنماط التصميم (Design Patterns)** لضمان تنظيم الكود وسهولة الصيانة.

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
///    كتابتهم في الsql ضمن القاعدة 
 
🎯 أنماط التصميم المستخدمة
   الوصف                               النمط  
Repository	     OrderRepository لتنفيذ عمليات CRUD على جدول الطلبات
Service     	OrderService لتنفيذ منطق إنشاء الطلب وحساب السعر
Observer    	OrderObserver لتسجيل حدث إنشاء الطلب في order_logs
Facade	         OrderFacade لتبسيط استدعاء الخدمات من نقطة واحدة
Singleton	      Settings لتخزين إعدادات النظام مثل VAT وتكلفة الشحن

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