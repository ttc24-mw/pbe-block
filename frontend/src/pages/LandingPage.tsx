import React, { useEffect, useState } from "react";
import Header from "../components/Header";
import Navbar from "../components/Navbar";
import Article, { IArticle } from "../components/Article";
import { api } from "../api";
import Pagination from "components/Pagination";
import { Link } from "react-router-dom";

export default function LandingPage(): React.JSX.Element {
    const [articles, setArticles] = useState<IArticle[]>([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);

    const fetchArticles = async (currentPage: number) => {
        const data = await api.getArticles(currentPage);
        setArticles(data.articles);
        setTotalPages(data.totalPages);
    };

    useEffect(() => {
        fetchArticles(currentPage);
    }, [currentPage]);

    return (
        <>
            <Header />
            <Navbar />
            <div>
                <ul>
                    {articles.map((article) => (
                        <li key={article.id}>
                            <Link to={`/detail/${article.id}`}>
                                <Article article={article} />
                            </Link>
                        </li>
                    ))}
                </ul>
                <Pagination
                    totalPages={totalPages}
                    currentPage={currentPage}
                    onPageChange={setCurrentPage}
                />
            </div>
        </>
    );
}
