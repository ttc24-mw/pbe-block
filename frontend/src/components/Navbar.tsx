import { Link } from "react-router-dom";
import { useAuth } from "AuthContext";

export default function Navbar(): React.JSX.Element {
    const { isLoggedIn, handleLogout } = useAuth();

    return (
        <nav className='flex justify-between space-x-4 border-y-2 py-2 px-4 w-full'>
            <div className='flex space-x-6'>
                <Link to='/'>Übersicht</Link>
                {isLoggedIn && <Link to='/newEntry'>Neuer Eintrag</Link>}
                <Link to='/impressum'>Impressum</Link>
            </div>
            {isLoggedIn ? (
                <button type='button' onClick={handleLogout}>
                    Logout
                </button>
            ) : (
                <Link to='/login'>Login</Link>
            )}
        </nav>
    );
}
