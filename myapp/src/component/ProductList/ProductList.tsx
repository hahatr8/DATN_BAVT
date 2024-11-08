import React, { useEffect, useState } from "react";
import axiosInstance from "../../axios/api";
import { Product } from "../../interface/types";
import "../../style/style.scss";
import { Link } from "react-router-dom";

const ProductList: React.FC = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await axiosInstance.get<Product[]>("/products");
        setProducts(response.data);
      } catch (error) {
        console.error("Error fetching products:", error);
        setError("Failed to fetch products.");
      }
    };

    fetchProducts();
  }, []);

  if (error) {
    return <div>{error}</div>;
  }

  return (
    <div className="product-list-container">
      <h1>Product List</h1>
      {products.length > 0 ? (
        <div className="product-list">
          {products.map((product) => (
            <div className="product-item" key={product.id}>
              <Link to={`/products/${product.id}`}>
                <img
                  src={product.image}
                  alt={product.name}
                  className="product-image"
                />

                <h2>{product.name}</h2>
                <p>{product.description}</p>
                <p>
                  {product.price.toLocaleString("vi-VN", {
                    style: "currency",
                    currency: "VND",
                  })}
                </p>
              </Link>
              <button>Thêm vào giỏ hàng</button>
            </div>
          ))}
        </div>
      ) : (
        <p>Loading products...</p>
      )}
    </div>
  );
};

export default ProductList;
