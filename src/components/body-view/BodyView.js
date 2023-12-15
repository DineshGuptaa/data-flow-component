

const BodyView = (props) => {
    console.log("Tree Body view: " + props)
    return (
        <div>
            <h2>Childs Sibling Component</h2>
            <p>Data: {props.data.name}</p>
        </div>
    );
};

export default BodyView;