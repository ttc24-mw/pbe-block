import { api } from "api";
import React, { createContext, useState, useContext, ReactNode } from "react";
import Cookies from "js-cookie";

interface AuthContextType {
    isLoggedIn: boolean;
    setIsLoggedIn: React.Dispatch<React.SetStateAction<boolean>>;
    handleLogin: (username: string, password: string) => Promise<void>;
    handleLogout: () => void;
    errMsg: string;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const AuthProvider = ({
    children,
}: {
    children: ReactNode;
}): React.JSX.Element => {
    const checkAuth = Cookies.get("user") != null;
    const [isLoggedIn, setIsLoggedIn] = useState(checkAuth);
    const [errMsg, setErrMsg] = useState("");

    const handleLogin = async (username: string, password: string) => {
        const res = await api.login(username, password);
        if (res.status === "success") {
            setIsLoggedIn(true);
            Cookies.set("user", username);
            window.location.href = "/";
        } else {
            setErrMsg(res.msg);
        }
    };

    const handleLogout = async () => {
        const res = await api.logout();
        if (res.status === "success") {
            setIsLoggedIn(false);
            Cookies.remove("user");
            window.location.href = "/login";
        }
    };

    return (
        <AuthContext.Provider
            value={{
                isLoggedIn,
                setIsLoggedIn,
                handleLogin,
                handleLogout,
                errMsg,
            }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => {
    const context = useContext(AuthContext);
    if (!context) throw new Error("useAuth must be used within AuthProvider");
    return context;
};
