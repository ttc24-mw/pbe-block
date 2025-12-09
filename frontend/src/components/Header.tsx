import { Link } from "react-router-dom";

export default function Header (): React.JSX.Element {
  return (
    <header className="flex items-center p-4 bg-gray-200 dark:bg-gray-800">
      <Link to="/">
        <img src="../img/dummyLogo.jpeg" alt="logo" className="w-[200px] h-[100px] bg-slate-400" />
      </Link>
      <h1 className="font-bold text-zinc-200 ml-5">My Blog App</h1>
    </header>
  );
};