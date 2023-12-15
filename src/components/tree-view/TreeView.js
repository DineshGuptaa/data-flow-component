import React, { useState } from 'react';

const TreeNode = ({ node, setData }) => {
    const [isExpanded, setIsExpanded] = useState(false);

    const handleToggle = () => {
        setIsExpanded(!isExpanded);
        setData(node.name);
    };

    return (
        <div className="tree-node">
            <div onClick={handleToggle} className={`node-toggle ${isExpanded ? 'expanded' : ''}`}>
                {isExpanded && node.children.length > 0 ? '-' : '+'} {node.name}
            </div>
            {isExpanded && (
                <ul className="child-nodes">
                    {node.children.map((childNode) => (
                        <li key={childNode.id}>
                            <TreeNode node={childNode} setData={setData} />
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
};


const TreeView = ({ data, setData }) => {
    return (
        <div>
            {data.map((rootNode) => (
                <TreeNode key={rootNode.id} node={rootNode} setData={setData} />
            ))}
        </div>
    );
};

export default TreeView;