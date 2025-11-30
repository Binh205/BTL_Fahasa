CREATE DATABASE IF NOT EXISTS `fahasa` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `fahasa`;


DROP TABLE IF EXISTS Order_Voucher;
DROP TABLE IF EXISTS Order_Product;
DROP TABLE IF EXISTS Cart_Product;
DROP TABLE IF EXISTS Flashsale_Product;
DROP TABLE IF EXISTS Shipment_Order;
DROP TABLE IF EXISTS Categorizes;
DROP TABLE IF EXISTS Category_Product;
DROP TABLE IF EXISTS Author_of_product;
DROP TABLE IF EXISTS ProductReview;
DROP TABLE IF EXISTS Product_Image;
DROP TABLE IF EXISTS User_phone;
DROP TABLE IF EXISTS User_address;
DROP TABLE IF EXISTS Staff;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS Cart;
DROP TABLE IF EXISTS Shipment;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS FlashSale;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Voucher;
DROP TABLE IF EXISTS Users;


------1-----
CREATE TABLE Users (
    user_id INT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    note VARCHAR(MAX),
    created_date DATE,
    
    CONSTRAINT CHK_User_CreatedDate CHECK (created_date <= GETDATE())
);
------2-----
CREATE TABLE Staff (
    user_id INT PRIMARY KEY,
    branch VARCHAR(100),
    hired_date DATE,
    salary DECIMAL(12,2),
    is_admin BIT DEFAULT 0,

    CONSTRAINT FK_Staff_User FOREIGN KEY (user_id) REFERENCES Users(user_id),
    CONSTRAINT CHK_Staff_Salary CHECK (salary >= 0) 
);

-----3-----
CREATE TABLE Customer (
    user_id INT PRIMARY KEY,
    member_type VARCHAR(50), 
    total_fpoint INT DEFAULT 0,
    CONSTRAINT FK_Customer_User FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-----4-----
CREATE TABLE User_phone (
    user_id INT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    PRIMARY KEY (user_id, phone),
    CONSTRAINT FK_UserPhone_User FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-----5-----
CREATE TABLE User_address (
    user_id INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id, address),
    CONSTRAINT FK_UserAddress_User FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-----6-----
CREATE TABLE Payment (
    payment_id INT PRIMARY KEY IDENTITY(1,1),
    customer_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_date DATE,
    CONSTRAINT FK_Payment_Customer FOREIGN KEY (customer_id) REFERENCES Customer(user_id)
);

-----7-----
CREATE TABLE Orders (
    order_id INT PRIMARY KEY IDENTITY(1,1),
    payment_id INT,
    shipping_fee DECIMAL(12,2) DEFAULT 0,
    note VARCHAR(MAX),
    created_date DATE,
    status VARCHAR(50),
    point_earned INT DEFAULT 0,
    point_used INT DEFAULT 0,
    total DECIMAL(12, 2) DEFAULT 0, 

    CONSTRAINT FK_Order_Payment FOREIGN KEY (payment_id) REFERENCES Payment(payment_id),
    CONSTRAINT CHK_Order_Total CHECK (total >= 0)
);

-----8-----
CREATE TABLE Voucher (
    voucher_code VARCHAR(50) PRIMARY KEY,
    usage_limit INT,
    used_count INT DEFAULT 0,
    start_time DATETIME,
    end_time DATETIME,
    min_order_value DECIMAL(12,2),
    max_sale_value DECIMAL(12,2),
    discount DECIMAL(10, 2) NOT NULL,

    CONSTRAINT CHK_Voucher_Time CHECK (start_time < end_time),
    CONSTRAINT CHK_Voucher_Values CHECK (min_order_value >= 0 AND max_sale_value >= 0 AND discount >= 0)
);

-----9-----
CREATE TABLE Order_Voucher (
    order_id INT, 
    voucher_code VARCHAR(50),
    PRIMARY KEY (order_id, voucher_code),
    CONSTRAINT FK_OV_Order FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    CONSTRAINT FK_OV_Voucher FOREIGN KEY (voucher_code) REFERENCES Voucher(voucher_code)
);

-----10-----
CREATE TABLE Cart (
    cart_id VARCHAR(20) PRIMARY KEY,
    quantity INT,
    customer_id INT NOT NULL,

    CONSTRAINT FK_Cart_Customer FOREIGN KEY (customer_id) REFERENCES Customer(user_id) 
);

-----11-----
CREATE TABLE Product (
    product_id INT PRIMARY KEY IDENTITY(1,1),
    title VARCHAR(255) NOT NULL,
    publisher VARCHAR(100),
    supplier VARCHAR(100),
    description VARCHAR(MAX),
    year INT,
    language VARCHAR(50),
    product_type VARCHAR(50),
    stock_quantity INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    weight DECIMAL(10, 2),
    size VARCHAR(2),

    CONSTRAINT CHK_Product_Price CHECK (price >= 0),
    CONSTRAINT CHK_Product_Stock CHECK (stock_quantity >= 0)
);

-----12-----
CREATE TABLE Author_of_product (
    product_id INT NOT NULL,
    author_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (product_id, author_name),

    CONSTRAINT FK_Au_Product FOREIGN KEY (product_id) REFERENCES Product(product_id)
);

-----13-----
CREATE TABLE Order_Product (
    order_id INT,
    product_id INT,
    quantity INT NOT NULL, 
    PRIMARY KEY (order_id, product_id),

    CONSTRAINT FK_OP_Order FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    CONSTRAINT FK_OP_Product FOREIGN KEY (product_id) REFERENCES Product(product_id),
    CONSTRAINT CHK_OP_Quantity CHECK (quantity > 0)
);

-----14-----
CREATE TABLE Cart_Product (
    card_id VARCHAR(20),
    product_id INT,
    PRIMARY KEY (card_id, product_id),

    CONSTRAINT FK_CP_Cart FOREIGN KEY (card_id) REFERENCES Cart(cart_id),
    CONSTRAINT FK_CP_Product FOREIGN KEY (product_id) REFERENCES Product(product_id)
);

-----15-----
CREATE TABLE ProductReview (
    review_id INT,
    product_id INT NOT NULL,
    customer_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    review_text VARCHAR(MAX),
    review_date DATETIME,
    image_url VARCHAR(255), 
    PRIMARY KEY (product_id, review_id),

    CONSTRAINT FK_PR_Product FOREIGN KEY (product_id) REFERENCES Product(product_id),
    CONSTRAINT FK_PR_Customer FOREIGN KEY (customer_id) REFERENCES Customer(user_id)
);

-----16-----
CREATE TABLE Product_Image (
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL, 
    ordinal_number INT,
    upload_date DATETIME,
    PRIMARY KEY (product_id, image_url),

    CONSTRAINT FK_PI_Product FOREIGN KEY (product_id) REFERENCES Product(product_id)
);

-----17-----
CREATE TABLE FlashSale (
    sale_id INT PRIMARY KEY,
    start_time DATETIME2 NOT NULL,
    end_time DATETIME2 NOT NULL,
    description VARCHAR(MAX),

    CONSTRAINT CHK_Flashsale_Time CHECK (start_time < end_time)
);

-----18-----
CREATE TABLE Flashsale_Product (
    sale_id INT,
    product_id INT,
    discount_value DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (sale_id, product_id),

    CONSTRAINT FK_FSP_Flashsale FOREIGN KEY (sale_id) REFERENCES FlashSale(sale_id),
    CONSTRAINT FK_FSP_Product FOREIGN KEY (product_id) REFERENCES Product(product_id),
    CONSTRAINT CHK_FSP_Values CHECK (discount_value >= 0 AND quantity >= 0)
);

-----19-----
CREATE TABLE Category (
    category_id INT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(MAX)
);

-----20-----
CREATE TABLE Categorizes (
    categoryA_id INT NOT NULL,
    categoryB_id INT PRIMARY KEY,

    CONSTRAINT FK_Cg_CategoryA FOREIGN KEY (categoryA_id) REFERENCES Category(category_id),
    CONSTRAINT FK_Cg_CategoryB FOREIGN KEY (categoryB_id) REFERENCES Category(category_id),
    CONSTRAINT CHK_Categorizes_SelfRef CHECK (categoryA_id <> categoryB_id)
);

-----21-----
CREATE TABLE Category_Product (
    category_id INT NOT NULL,
    product_id INT NOT NULL,
    PRIMARY KEY (category_id, product_id),

    CONSTRAINT FK_CtP_Category FOREIGN KEY (category_id) REFERENCES Category(category_id),
    CONSTRAINT FK_CtP_Product FOREIGN KEY (product_id) REFERENCES Product(product_id)
);

-----22-----
CREATE TABLE Shipment (
    ship_code VARCHAR(50) PRIMARY KEY, 
    shipping_unit VARCHAR(100) NOT NULL, 
    tracking_num VARCHAR(100), 
    weight DECIMAL(10, 2),
    status VARCHAR(50) NOT NULL, 
    last_update DATETIME2,
    shipping_address VARCHAR(50),
    note VARCHAR(MAX),
    
    CONSTRAINT CHK_Shipment_Weight CHECK (weight >= 0)
);

-----23-----
CREATE TABLE Shipment_Order (
    ship_code VARCHAR(50) PRIMARY KEY,
    order_id INT, 

    CONSTRAINT FK_SO_Shipment FOREIGN KEY (ship_code) REFERENCES Shipment(ship_code),
    CONSTRAINT FK_SO_Order FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);