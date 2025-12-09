import React, { useState } from "react";
import Header from "../components/Header";
import Navbar from "../components/Navbar";
import { api } from "api";

export default function NewEntryPage(): React.JSX.Element {
    const [title, setTitle] = useState("");
    const [url, setUrl] = useState("");
    const [text, setText] = useState("");

    const labelClasses = "w-[150px] mr-4 align-top";
    const FieldClasses = "w-[400px] bg-gray-200 border-1 border-gray-900";

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const res = await api.postArticle(title, text, url);
        if (res.status === "success") {
            window.location.href = "/";
        }
    };

    return (
        <div className='relative'>
            <Header />
            <Navbar />
            <form
                method='post'
                onSubmit={handleSubmit}
                className='flex flex-col space-x-2 bg-blue-200 mt-8 p-4 w-full'>
                <table className='table-auto'>
                    <tbody>
                        <tr>
                            <td className={labelClasses}>
                                <label htmlFor='title'>Titel*:</label>
                            </td>
                            <td>
                                <input
                                    id='title'
                                    type='text'
                                    name='title'
                                    className={FieldClasses}
                                    onChange={(e) => setTitle(e.target.value)}
                                    required
                                />
                            </td>
                        </tr>
                        <tr>
                            <td className={labelClasses}>
                                <label htmlFor='url'>Link zum Bild:</label>
                            </td>
                            <td>
                                <input
                                    id='url'
                                    type='text'
                                    name='url'
                                    className={FieldClasses}
                                    onChange={(e) => setUrl(e.target.value)}
                                />
                            </td>
                        </tr>
                        <tr>
                            <td className={labelClasses}>
                                <label htmlFor='comment'>Text*:</label>
                            </td>
                            <td>
                                <textarea
                                    value={text}
                                    onChange={(e) => setText(e.target.value)}
                                    className={`${FieldClasses} w-full min-h-[200px]`}
                                    required
                                />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button
                                    type='submit'
                                    className='border border-blue-300 bg-slate-200 rounded mt-4 p-2 w-[150px]'>
                                    Absenden
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    );
}
