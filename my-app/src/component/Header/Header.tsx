import React from 'react';
import { Link } from 'react-router-dom';
import './Header.scss';

const Header = () => {
  return (
    <>
      <header className="header">
        <div className="container">
          {/* Logo */}
          <div className="logo">
            <Link to="/">
              <img src="../image/logo.png" alt="Logo" />
            </Link>
          </div>

          {/* Menu */}
          <nav className="perfume-menu">
            <ul>
              <li><Link to="/perfumes/male">Nước Hoa Nam</Link></li>
              <li><Link to="/perfumes/female">Nước Hoa Nữ</Link></li>
              <li><Link to="/perfumes/unisex">Nước Hoa Unisex</Link></li>
              <li><Link to="/perfumes/sale">Khuyến Mãi</Link></li>
              <li><Link to="/about">Về Chúng Tôi</Link></li>
            </ul>
          </nav>

          {/* Đăng nhập/Đăng ký và Giỏ hàng */}
          <div className="user-actions">
            <div className="auth-links">
              <Link to="/login" className="login-link">Đăng Nhập</Link>
            </div>
            
            {/* Giỏ hàng */}
            <div className="cart">
              <Link to="/cart">
                <img src="../image/cart-icon.png" alt="Giỏ hàng" className="cart-icon" />
              </Link>
            </div>

            {/* Avatar khi đã đăng nhập */}
            <div className="avatar">
              <img src="..image/avatar-placeholder.png" alt="Avatar" /> {/* Thay bằng avatar thực tế */}
            </div>
          </div>
        </div>
      </header>
    </>
  );
};

export default Header;
