import React from "react";

export interface IArticle {
    id: number;
    title: string;
    content: string;
    authorName: string;
    createdAt: string;
    picture_url?: string;
    commentsCount?: number;
}

interface Props {
    article: IArticle;
    isDetailView?: boolean;
}

const truncateTxt = (text: string) => {
    const maxLength = 400;
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + "...";
};

export default function Article(prop: Props): React.JSX.Element {
    const {
        title,
        content,
        authorName,
        createdAt,
        picture_url,
        commentsCount,
    } = prop.article;
    const isDetailView = prop.isDetailView || false;

    return (
        <div
            className={`${
                isDetailView
                    ? "flex-col"
                    : "flex flex-row-reverse justify-between"
            } space-x-2 bg-blue-200 mt-4 p-4 cursor`}>
            {isDetailView && <h1 className='text-lg font-bold'>{title}</h1>}
            <img
                src={"../img/Placeholder.jpeg"}
                alt='img'
                className={`m-4 object-cover ${
                    isDetailView ? "w-[80%] h-auto py-4 mx-auto" : "w-auto h-60"
                }`}
            />
            <div className='m-4 w-full'>
                {createdAt}
                {!isDetailView && <span> - {title}</span>}
                <div className='my-4 break-all'>
                    {isDetailView ? (
                        <div className='my-8'>
                            <div>{content}</div>
                            <div className='my-4'>{content}</div>
                            <div>{content}</div>
                        </div>
                    ) : (
                        truncateTxt(content)
                    )}
                </div>
                <div className='flex justify-between'>
                    <p>Author: {authorName}</p>
                    {!isDetailView && <p>Kommentare: {commentsCount || 0}</p>}
                </div>
            </div>
        </div>
    );
}
