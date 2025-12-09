import React, { useState } from "react";
import Header from "../components/Header";
import Navbar from "../components/Navbar";
import { useAuth } from "AuthContext";

export default function LoginPage(): React.JSX.Element {
    const { handleLogin, errMsg } = useAuth();

    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        handleLogin(username.trim(), password.trim());
    };

    const labelClasses = "w-[200px] mr-4 align-top";
    const FieldClasses = "w-[400px] bg-gray-200 border-1 border-gray-900";

    return (
        <>
            <Header />
            <Navbar />
            <form
                method='post'
                onSubmit={handleSubmit}
                id='login'
                className='flex flex-col space-x-2 bg-blue-200 mt-4 p-4 w-full'>
                <table className='table-auto'>
                    <tbody>
                        <tr>
                            <td className={labelClasses}>
                                <label htmlFor='name'>Benutzername:</label>
                            </td>
                            <td>
                                <input
                                    id='name'
                                    type='text'
                                    value={username}
                                    onChange={(e) => {
                                        e.preventDefault();
                                        setUsername(e.target.value);
                                    }}
                                    className={FieldClasses}
                                    required
                                />
                            </td>
                        </tr>
                        <tr>
                            <td className={labelClasses}>
                                <label htmlFor='email'>Passwort:</label>
                            </td>
                            <td>
                                <input
                                    id='password'
                                    type='password'
                                    value={password}
                                    onChange={(e) =>
                                        setPassword(e.target.value)
                                    }
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
                                    className='border-1 border-blue-300 bg-slate-200 mt-4 px-8'>
                                    Login
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                {errMsg && <p className='text-red-600 mt-4'>{errMsg}</p>}
            </form>
        </>
    );
}
