import React from "react";
import { Route, Routes } from "react-router-dom";
import Header from "../component/Header/Header";
import Banner from "../component/Banner/Banner";
import ProductList from "../component/ProductList/ProductList";
import Footer from "../component/Footer/Footer";
import ProductDetail from "../component/ProductDetail/ProductDetail";

const Home = () => {
  return (
    <div>
      <div className="overlay">
        <h4>NƯỚC HOA CHÍNH HÃNG 2024</h4>
        <div className="text_gt">
          <img src="" alt="gt" />
          <p>| Giới thiệu về Symphony |</p>
          <img src="" alt="blog" />
          <p>| Blog cẩm nang nước hoa</p>
        </div>
      </div>
      <Header />
      <Banner />
      <main>
        <Routes>
          <Route path="/" element={<ProductList />} />
          <Route path="products/:id" element={<ProductDetail />} />
        </Routes>
      </main>
      <Footer />
    </div>
  );
};

export default Home;
