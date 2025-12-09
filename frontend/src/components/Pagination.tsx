interface PaginationProps {
    totalPages: number;
    currentPage: number;
    onPageChange: (page: number) => void;
}

export default function Pagination(props: PaginationProps): React.JSX.Element {
    const { totalPages, currentPage, onPageChange } = props;

    const pages = Array.from({ length: totalPages }, (_, i) => i + 1);

    return (
        <div className='flex justify-center my-4 border-2 border-slate-400 p-2 mx-auto w-[70%] text-gray-500'>
            {pages.map((page) => (
                <div key={page} className='m-0'>
                    <button
                        onClick={() => onPageChange(page)}
                        className={`${
                            page === currentPage
                                ? "underline text-blue-600"
                                : ""
                        }`}>
                        {page}
                    </button>
                    {page !== totalPages && <span className='px-2'>-</span>}
                </div>
            ))}
        </div>
    );
}
