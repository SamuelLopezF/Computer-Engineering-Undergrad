package SimpleTree;

public class SimpleTree <Integer,E extends Comparable<E>> {
    public SimpleTreeNode<Integer, E> root;
    public SimpleTree()
    {
        root = null;
    }

    private SimpleTreeNode<Integer, E> add(SimpleTreeNode<Integer, E> current, int key, E it) {
        if(current == null)
        {
            SimpleTreeNode temp = new SimpleTreeNode<>(key, it);
            return temp;
        }
        if(it.compareTo(current.value) < 0 )
        {
            current.left = add(current.left, key, it);
        }
        if(it.compareTo(current.value) > 0)
        {
            current.right = add(current.right, key, it);
        }else{
            return current;
        }
        return current;
    }
    public void addFromRoot(int key, E it) {
        root = add(root, key, it);
    }

    public SimpleTreeNode<Integer,E> getRoot()
    {
        return this.root;
    }

    public void traverseInOrder(SimpleTreeNode<Integer, E> node) {
        if (node != null) {
            traverseInOrder(node.left);
            System.out.print(" " + node.index);
            traverseInOrder(node.right);
        }
    }

    public void traverseInOrderValues(SimpleTreeNode<Integer, E> node)
    {
        if (node != null) {
            traverseInOrderValues(node.left);
            System.out.print(" " + node.value);
            traverseInOrderValues(node.right);
        }
    }
}