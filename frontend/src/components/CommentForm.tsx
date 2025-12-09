import { api } from "api";
import { useState } from "react";

interface FormProps {
    id?: string;
    fetchComments: () => {};
}

export default function CommentForm(props: FormProps): React.JSX.Element {
    const { id, fetchComments } = props;

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [url, setUrl] = useState("");
    const [commentText, setCommentText] = useState("");

    const labelClasses = "w-[150px] mr-4 align-top";
    const FieldClasses = "w-full bg-gray-200 border-1 border-gray-900";

    const handleCommentSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        if (
            id &&
            name.trim() !== "" &&
            email.trim() !== "" &&
            commentText.trim() !== ""
        ) {
            const res = await api.postComment(
                Number(id),
                name,
                email,
                url,
                commentText
            );
            if (res) {
                fetchComments();
                setName("");
                setEmail("");
                setUrl("");
                setCommentText("");
            }
        }
    };

    return (
        <form
            method='post'
            onSubmit={handleCommentSubmit}
            className='flex flex-col space-x-2 bg-blue-200 mt-8 p-4 w-full'>
            <table className='table-auto'>
                <tbody>
                    <tr>
                        <td className={labelClasses}>
                            <label htmlFor='name'>Name*:</label>
                        </td>
                        <td>
                            <input
                                value={name}
                                type='text'
                                name='name'
                                onChange={(e) => setName(e.target.value)}
                                className={FieldClasses}
                                required
                            />
                        </td>
                    </tr>
                    <tr>
                        <td className={labelClasses}>
                            <label htmlFor='email'>Mail*:</label>
                        </td>
                        <td>
                            <input
                                value={email}
                                type='email'
                                name='email'
                                onChange={(e) => setEmail(e.target.value)}
                                className={FieldClasses}
                                required
                            />
                        </td>
                    </tr>
                    <tr>
                        <td className={labelClasses}>
                            <label htmlFor='url'>URL:</label>
                        </td>
                        <td>
                            <input
                                value={url}
                                type='text'
                                name='url'
                                onChange={(e) => setUrl(e.target.value)}
                                className={FieldClasses}
                            />
                        </td>
                    </tr>
                    <tr>
                        <td className={labelClasses}>
                            <label htmlFor='comment'>Kommentare*:</label>
                        </td>
                        <td>
                            <textarea
                                value={commentText}
                                onChange={(e) => setCommentText(e.target.value)}
                                className={FieldClasses}
                                required
                            />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button
                                type='submit'
                                className='border border-blue-300 bg-slate-200 rounded mt-4 p-2'>
                                Absenden
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    );
}
