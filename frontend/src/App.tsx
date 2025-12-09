import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import LandingPage from "./pages/LandingPage";
import DetailPage from "./pages/DetailPage";
import LoginPage from "./pages/LoginPage";
import NewEntryPage from "./pages/NewEntryPage";
import ImpressumPage from "./pages/ImpressumPage";

export default function App(): React.JSX.Element {
    return (
        <Router>
            <Routes>
                <Route path='/' element={<LandingPage />} />
                <Route path='/detail/:id' element={<DetailPage />} />
                <Route path='/login' element={<LoginPage />} />
                <Route path='/newEntry' element={<NewEntryPage />} />
                <Route path='/impressum' element={<ImpressumPage />} />
            </Routes>
        </Router>
    );
}
