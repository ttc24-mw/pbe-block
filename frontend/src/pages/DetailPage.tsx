import React, { useEffect, useState } from "react";
import Header from "../components/Header";
import Navbar from "../components/Navbar";
import { useParams } from "react-router-dom";
import Article, { IArticle } from "components/Article";
import { api } from "api";
import { useAuth } from "AuthContext";
import CommentForm from "components/CommentForm";

export interface Comment {
    id: number;
    article_id: number;
    name: string;
    email: string;
    url: string;
    comment_text: string;
    created_at: string;
}

export default function DetailPage(): React.JSX.Element {
    const { id } = useParams<{ id: string }>();
    const { isLoggedIn } = useAuth();

    const [article, setArticle] = useState<IArticle | null>(null);
    const [comments, setComments] = useState<Comment[]>([]);

    const fetchArticle = async () => {
        if (id) {
            const res = await api.getArticleById(Number(id));
            setArticle(res);
        }
    };

    const fetchComments = async () => {
        if (id) {
            const res = await api.getComments(Number(id));
            setComments(res);
        }
    };

    useEffect(() => {
        fetchArticle();
        fetchComments();
    }, []);

    const handleCommentDelete = async (comment_id: number) => {
        if (comment_id) {
            if (window.confirm("Bist du dir sicher???")) {
                const success = await api.deleteComment(Number(comment_id));
                if (success) {
                    fetchComments();
                }
            }
        }
    };

    if (!article) return <div>Artikel nicht verfügbar...</div>;

    return (
        <>
            <Header />
            <Navbar />
            <main className='mb-10'>
                <Article isDetailView article={article} />
                {comments.length > 0 ? (
                    <section className='ml-12 p-4'>
                        {comments.map((comment, i) => (
                            <div key={comment.id} className='mb-2'>
                                {i + 1}. <strong>{comment.name}</strong> am (
                                {comment.created_at}): {comment.comment_text}
                                {isLoggedIn && (
                                    <button
                                        onClick={() =>
                                            handleCommentDelete(comment.id)
                                        }
                                        className='ml-2 text-gray-500'>
                                        [X]
                                    </button>
                                )}
                            </div>
                        ))}
                    </section>
                ) : (
                    <div className='ml-12 p-4'>Keine Kommentare vorhanden.</div>
                )}
                {isLoggedIn && (
                    <CommentForm id={id} fetchComments={fetchComments} />
                )}
            </main>
        </>
    );
}
